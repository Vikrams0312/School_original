<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller {

    //  login
    public function logout(Request $request) {
        $request->session()->flush();
        return redirect('/login');
    }

    public function loginAuthentication(Request $req) {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $req->input('email');
        $password = $req->input('password');
        $where = [
            'email' => $email,
            'password' => sha1($password)
        ];
        // Retrieve the user data
        $user = DB::table('teachers')
                ->join('designations', 'teachers.designation_id', '=', 'designations.id')
                ->select('teachers.*', 'designations.designation as designation_name')
                ->where('teachers.email', $email)
                ->where('teachers.password', sha1($password))
                ->first();

        // Check if the user exists and verify the password
        if ($user && $user->password === sha1($password)) { // Ideally, use Hash::check for hashed passwords
            $data = [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_name' => $user->name,
                'user_designation' => $user->designation_name
            ];
            $req->session()->put($data);
            return redirect('/dashboard');
        } else {
            //return back()->withErrors(['error' => 'This department is already exist.']);
            return back()->withErrors(['error' => 'Email or password is incorrect.'])->withInput();
        }
    }

    public function dashboard() {
        return view('admin/login/dashboard');
    }

    public function saveMark(Request $request) {
        $examId = $request->input('exam');
        $standard = $request->input('standard');
        $group = $request->input('group');
        $section = $request->input('section');
        $subject_id = $request->input('subject');
        $subject = DB::table('subjects')
                ->where('id', $subject_id)
                ->value('subject_name');   // or whatever column name you store as group name

        $academic_year = $request->input('academic_year');
        $marks = $request->input('marks');     // student_id => mark
        $groupName = DB::table('groups')
                ->where('id', $group)
                ->value('group_short_name');   // or whatever column name you store as group name
        $groupName = strtolower($groupName);
        $tableName = "mark_" . $standard . "_" . $groupName . "_" . $academic_year;
        $academic_year = str_replace('-', '_', $academic_year);

        // ✅ Decide table name
        if ((int) $standard <= 10) {
            $tableName = "mark_{$standard}_{$academic_year}";
        } else {
            $tableName = "mark_{$standard}_{$groupName}_{$academic_year}";
        }

        foreach ($marks as $studentId => $mark) {
            $student = DB::table('students')->find($studentId);
            if (!$student)
                continue;

            // ✅ Insert or update only the subject column
            DB::table($tableName)->updateOrInsert(
                    [
                        'enrollno' => $student->enrollno,
                        'exam_id' => $examId,
                    ],
                    [
                        'standard' => $standard,
                        'section' => $section,
                        $subject => $mark, // ✅ Only this subject changes
                        'updated_at' => now(),
                    ]
            );

            // ✅ Recalculate total for this student
            $row = DB::table($tableName)
                    ->where('enrollno', $student->enrollno)
                    ->where('exam_id', $examId)
                    ->first();

            if ($row) {
                $columns = Schema::getColumnListing($tableName);

                // take only subject columns
                $subjectColumns = array_diff($columns, [
                    'id', 'enrollno', 'standard', 'section', 'exam_id',
                    'total', 'student_rank', 'updated_at', 'editing_status', 'created_at'
                ]);

                $total = 0;
                foreach ($subjectColumns as $col) {
                    if (!is_null($row->$col)) {
                        $total += (int) $row->$col;
                    }
                }

                DB::table($tableName)
                        ->where('enrollno', $student->enrollno)
                        ->where('exam_id', $examId)
                        ->update(['total' => $total]);
            }
        }

        return redirect()->back()->withInput()->with('success', 'Marks saved successfully!');
    }

    private function generateMarksTable($students, $subject_name, $examId, $standard, $group, $section, $academic_year) {
        $groupName = DB::table('groups')
                ->where('id', $group)
                ->value('group_short_name');
        $groupName = strtolower($groupName);

        $academic_year_safe = str_replace('-', '_', $academic_year);

        // Decide marks table name
        if ((int) $standard <= 10) {
            $tableName = "mark_{$standard}_{$academic_year_safe}";
        } else {
            $tableName = "mark_{$standard}_{$groupName}_{$academic_year_safe}";
        }

        $html = '<h3 class="mb-3 text-center">' . htmlspecialchars($subject_name) . ' Mark Entry</h3>';
        $html .= '<form method="POST" action="' . url('save-marks') . '">';
        $html .= csrf_field();

        // hidden fields
        $html .= '<input type="hidden" name="exam" value="' . $examId . '">';
        $html .= '<input type="hidden" name="standard" value="' . $standard . '">';
        $html .= '<input type="hidden" name="group" value="' . $group . '">';
        $html .= '<input type="hidden" name="section" value="' . $section . '">';
        $html .= '<input type="hidden" name="subject" value="' . request('subject') . '">';
        $html .= '<input type="hidden" name="academic_year" value="' . $academic_year . '">';

        $html .= '<div class="table-responsive"><table class="table table-bordered table-sm">';
        $html .= '<thead class="table-light"><tr>
                <th>Enroll.NO</th>
                <th>Name</th>
                <th>Mark</th>
              </tr></thead><tbody>';

        if ($students->isEmpty()) {
            $html .= '<tr><td colspan="3" class="text-center">No students found for this selection.</td></tr>';
        } else {
            foreach ($students as $student) {
                // 🔎 Get saved mark for this student, exam, subject
                $savedMark = DB::table($tableName)
                        ->where('enrollno', $student->enrollno)
                        ->where('exam_id', $examId)
                        ->value($subject_name);

                $html .= '<tr>
                        <td>' . $student->enrollno . '</td>
                        <td>' . $student->name . '</td>
                        <td>
                            <select class="mySelect" style="width:200px;" 
                                    name="marks[' . $student->id . ']">';

                // Default empty option
                $html .= '<option></option>';

                // Absent option
                $html .= '<option value="-1" ' . (($savedMark == -1) ? 'selected' : '') . '>Absent</option>';

                // If mark exists and is numeric
                if (!is_null($savedMark) && $savedMark != -1) {
                    $html .= '<option value="' . $savedMark . '" selected>' . $savedMark . '</option>';
                }

                $html .= '</select>
                        </td>
                      </tr>';
            }
        }

        $html .= '</tbody></table></div>';
        $html .= '<div class="mt-3 text-center">
                <button type="submit" class="btn btn-success">Save Marks</button>
              </div>';
        $html .= '</form>';

        return $html;
    }

    public function getStudentsByClass($standard, $group = null, $section = null) {
        $teacher_id = session('user_id');

        // Get teacher's allotments for the selected standard/group/section
        $allotments = DB::table('subject_allotments')
                ->where('teacher_id', $teacher_id)
                ->where('standard', $standard);

        if ($group && $group != 'NoSection') {
            $allotments->where('group_name_id', $group);
        }

        if ($section && $section != 'NoSection') {
            $allotments->where('section', $section);
        }

        // Get allowed sections/groups for teacher
        $allowedGroups = $allotments->pluck('group_name_id')->unique()->values();
        $allowedSections = $allotments->pluck('section')->unique()->values();

        // Fetch students in standard/section/group
        $studentsQuery = DB::table('students')
                ->where('standard', $standard);

        if ($group && $group != 'NoSection') {
            $studentsQuery->whereIn('group_id', $allowedGroups);
        }

        if ($section && $section != 'NoSection') {
            $studentsQuery->whereIn('section', $allowedSections);
        }

        $students = $studentsQuery->select('id', 'enrollno', 'name')->get();

        return response()->json($students);
    }

    public function getSubjectsByFilter($standard, $group = null, $section = null) {
        $teacher_id = session('user_id'); // or auth()->id()

        $query = DB::table('subject_allotments')
                ->where('teacher_id', $teacher_id)
                ->where('standard', $standard);

        // Only apply group filter if standard is 11 or 12
        if (in_array($standard, [11, 12]) && $group) {
            $query->where('group_name_id', $group);
        }

        // Apply section filter if provided
        if ($section) {
            $query->where('section', $section);
        }

        $subjects = $query->pluck('subject_id')->unique()->values();

        // Fetch subject names
        $subject_list = DB::table('subjects')->whereIn('id', $subjects)->get();

        return response()->json($subject_list);
    }

    public function getSectionsByStandard($standard, $group = null) {
        $teacher_id = session('user_id'); // or auth()->id()

        $query = DB::table('subject_allotments')
                ->where('teacher_id', $teacher_id)
                ->where('standard', $standard);

        // For standards 11 & 12, filter by group if provided
        if (in_array($standard, [11, 12]) && $group) {
            $query->where('group_name_id', $group);
        }

        $sections = $query->pluck('section')
                ->unique()
                ->values();

        return response()->json($sections);
    }

    public function getStandards($exam_id) {
        $teacher_id = session('user_id');

        // Get exam_name for this exam_id
        $exam_name = DB::table('exams')->where('id', $exam_id)->value('exam_name');

        // Standards for this exam_name
        $exam_standards = DB::table('exams')
                ->where('exam_name', $exam_name)
                ->pluck('standard');

        // Teacher's standards
        $teacher_standards = DB::table('subject_allotments')
                ->where('teacher_id', $teacher_id)
                ->pluck('standard')
                ->unique();

        // Intersection
        $standards = $teacher_standards->intersect($exam_standards)->sort()->values();

        return response()->json($standards);
    }

    public function markEntry(Request $request) {
        $teacher_id = session('user_id');
        $marks_table = null;
        $exams = DB::table('exams')
                ->selectRaw('MIN(id) as id, exam_name')
                ->groupBy('exam_name')
                ->orderBy('id')
                ->get();
        $Academic_year = DB::table('exams')
                ->select('academic_year')
                ->distinct()
                ->get();
        $allotments = DB::table('subject_allotments')
                ->where('teacher_id', $teacher_id)
                ->select('standard', 'group_name_id', 'section', 'subject_id')
                ->distinct()
                ->get();
        $groups = $allotments->pluck('group_name_id')->unique()->filter()->values();
        $group_list = DB::table('groups')->whereIn('id', $groups)->get();
        if ($request->isMethod('post')) {
            $standard = $request->input('standard');
            $group = $request->input('group');
            $section = $request->input('section');
            $subject_id = $request->input('subject');
            $examId = $request->input('exam');
            $academic_year = $request->input('academic_year');

            $subject_name = DB::table('subjects')->where('id', $subject_id)->value('subject_name');
            $students = DB::table('students')
                    ->where('standard', $standard)
                    ->when($group, fn($q) => $q->where('group_id', $group))
                    ->when($section, fn($q) => $q->where('section', $section))
                    ->select('id', 'enrollno', 'name')
                    ->get();

            $marks_table = $this->generateMarksTable($students, $subject_name, $examId, $standard, $group, $section, $academic_year);
        }


        return view('admin.mark.mark-entry', [
            'marks_table' => $marks_table,
            'exams' => $exams,
            'group_list' => $group_list,
            'Academic_year' => $Academic_year
        ]);
    }

    public function createMarkTable(Request $request) {
        $standard = $request->input('standard');
        $groupId = $request->input('group');
        $year = $request->input('academic_year');

        // Sanitize year for table name
        $yearSafe = str_replace(['-', ' '], '_', $year);

        // Get group short name for 11/12
        $groupShort = null;
        if ($standard > 10 && $groupId) {
            $groupShort = DB::table('groups')
                    ->where('id', $groupId)
                    ->value('group_short_name');
        }

        // Build table name
        $tableName = ($standard <= 10) ? "mark_{$standard}_{$yearSafe}" : "mark_{$standard}_{$groupShort}_{$yearSafe}";

        // Get subjects for the selected class/group
        if ($standard <= 10) {
            $subjects = DB::table('subjects')
                    ->where('standard', $standard)
                    ->get();
        } else {
            $subjects = DB::table('subjects')
                    ->where('standard', $standard)
                    ->where('group_id', $groupId)
                    ->get();
        }

        // Helper function to make subject names safe for columns
        $sanitize = function ($name) {
            // Lowercase
            $col = strtolower($name);
            // Replace spaces, dashes, slashes, dots, ampersands with underscore
            $col = preg_replace('/[^\w]+/', '_', $col);
            // Trim leading/trailing underscores
            $col = trim($col, '_');
            // Ensure it doesn't start with a number
            if (preg_match('/^\d/', $col)) {
                $col = 'sub_' . $col;
            }
            return $col;
        };

        // Convert subject names into safe column names
        $subjectColumns = $subjects->map(function ($sub) use ($sanitize) {
                    return $sanitize($sub->subject_name);
                })->toArray();

        // Create table if not exists
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function ($table) use ($subjects, $sanitize) {
                $table->id();
                $table->integer('enrollno');
                $table->integer('standard');
                $table->string('section', 2);

                foreach ($subjects as $sub) {
                    $col = $sanitize($sub->subject_name);
                    $table->integer($col)->nullable();
                }

                $table->integer('total')->nullable();
                $table->integer('student_rank')->nullable();
                $table->integer('exam_id')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->integer('editing_status')->default(0);
            });

            return back()->with('success', "Table created successfully.");
        }

        // ✅ Table already exists → check for differences
        $existingColumns = Schema::getColumnListing($tableName);
        $protectedCols = ['id', 'enrollno', 'standard', 'section', 'total', 'student_rank', 'exam_id', 'updated_at', 'editing_status'];

        $changed = false;

        // 1. Add missing subject columns
        foreach ($subjectColumns as $col) {
            if (!in_array($col, $existingColumns)) {
                Schema::table($tableName, function ($table) use ($col) {
                    $table->integer($col)->nullable()->after('section');
                });
                $changed = true;
            }
        }

        // 2. Drop all extra subject columns at once
        $extraCols = array_diff(
                array_diff($existingColumns, $protectedCols), // exclude protected
                $subjectColumns                              // exclude valid subjects
        );

        if (!empty($extraCols)) {
            Schema::table($tableName, function ($table) use ($extraCols) {
                $table->dropColumn($extraCols);
            });
            $changed = true;
        }

        if ($changed) {
            return back()->with('success', "Table updated successfully.");
        }

        return back()->with('error', "Table already exists.");
    }

    public function marktablepage(Request $request) {
        $standards = DB::table('groups')
                ->select(DB::raw('MIN(id) as id'), 'standard')
                ->groupBy('standard')
                ->orderBy('standard')
                ->get();

        $groups = DB::table('groups')
                ->select(DB::raw('MIN(id) as id'), 'group_short_name')
                ->whereNotNull('group_short_name')
                ->groupBy('group_short_name')
                ->orderBy('group_short_name')
                ->get();
        $academic_year = DB::table('students')
                ->select('academic_year')
                ->distinct()
                ->get();
        $selected_standard = $request->get('standard');
        $selected_group = $request->get('group');

        $subjects = collect(); // default empty

        if ($selected_standard) {
            if ($selected_standard <= 10) {
                // fetch subjects for classes 1–10
                $subjects = DB::table('subjects')
                        ->where('standard', $selected_standard)
                        ->get();
            } else if ($selected_standard >= 11 && $selected_group) {
                // fetch subjects for 11,12 with group
                $subjects = DB::table('subjects')
                        ->where('standard', $selected_standard)
                        ->where('group_id', $selected_group)
                        ->get();
            }
        }
        //dd($acdemic_year);
        return view('admin.mark.marktable', compact(
                        'standards', 'groups', 'selected_standard', 'selected_group', 'subjects', 'academic_year'
        ));
    }

    public function createExams() {
        $standards = DB::table('groups')
                ->select(DB::raw('MIN(id) as id'), 'standard')
                ->groupBy('standard')
                ->orderBy('standard')
                ->get();
        $academic_year = DB::table('students')
                ->select('academic_year')
                ->distinct()
                ->get();
        return view('admin/examList/create-exams', compact('standards', 'academic_year'));
    }

    public function saveExams(Request $req) {
        $req->validate([
            'standard' => 'required',
            'exam_name' => 'required|string|max:255',
            'academic_year' => 'required|string|regex:/^\d{4}-\d{4}$/', // Example: 2025-2026
        ]);
        // Insert into DB
        DB::table('exams')->insert([
            'standard' => $req->standard,
            'exam_name' => $req->exam_name,
            'academic_year' => $req->academic_year
        ]);

        return redirect('/create-exams')->with('success', 'Exam created successfully!');
    }

    public function listExams() {
        $exams = DB::table('exams')->orderBy('standard')->get();
        return view('admin.examList.list-exams', compact('exams'));
    }

    public function deleteExams($id) {
        DB::table('exams')->where('id', $id)->delete();
        return redirect('/list-exams')->with('success', 'Exam deleted successfully!');
    }

    // Show edit form
    public function editExams($id) {
        $exam = DB::table('exams')->where('id', $id)->first();
        $standards = DB::table('groups')
                ->select(DB::raw('MIN(id) as id'), 'standard')
                ->groupBy('standard')
                ->orderBy('standard')
                ->get(); // assuming you have standards table
        return view('admin.examList.edit-exams', compact('exam', 'standards'));
    }

// Update record
    public function updateExams(Request $req, $id) {
        $req->validate([
            'standard' => 'required',
            'exam_name' => 'required|string|max:255',
            'academic_year' => 'required|string|regex:/^\d{4}-\d{4}$/',
        ]);

        DB::table('exams')->where('id', $id)->update([
            'standard' => $req->standard,
            'exam_name' => $req->exam_name,
            'academic_year' => $req->academic_year
        ]);

        return redirect('/list-exams')->with('success', 'Exam updated successfully!');
    }

    public function createDesignation() {
        return view('admin/designation/create-designation');
    }

    public function saveDesignation(Request $request) {
        $request->validate([
            'designation_name' => 'required|string|max:255|unique:designations,designation'
        ]);

        DB::table('designations')->insert([
            'designation' => $request->input('designation_name')
        ]);

        return back()->with('success', 'Designation added successfully!');
    }

    public function designationList(Request $request) {
        // Fetch designation list
        $designations = DB::table('designations')->get();
        return view('admin.designation.designation-list', compact('designations'));
    }

    public function deleteDesignation($id) {
        $deleted = DB::table('designations')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['status' => 1, 'message' => 'Success']);
        } else {
            return response()->json(['status' => 0, 'message' => 'Failed']);
        }
    }

    public function editDesignation($id) {
        $designations = DB::table('designations')->where('id', $id)->first();
        return view('admin/designation/edit-designation', compact('designations'));
    }

    public function updateDesignation(Request $request, $id) {

        $request->validate([
            'designation_name' => 'required|string|max:255',
        ]);

        DB::table('designations')
                ->where('id', $id)
                ->update([
                    'designation' => $request->input('designation_name'),
        ]);

        return redirect('/designation-list')->with('success', 'Designation updated successfully!');
    }

    public function subjectForm() {
        // Get distinct standards with the smallest id for each
        $standards = DB::table('groups')
                ->select(DB::raw('MIN(id) as id'), 'standard')
                ->groupBy('standard')
                ->orderBy('standard')
                ->get();

        // Get distinct group short names with the smallest id for each
        $groupShortNames = DB::table('groups')
                ->select(DB::raw('MIN(id) as id'), 'group_short_name')
                ->whereNotNull('group_short_name')
                ->groupBy('group_short_name')
                ->orderBy('group_short_name')
                ->get();

        return view('admin.subject.create-subject', compact('standards', 'groupShortNames'));
    }

    public function createSubject(Request $req) {
        // Validate inputs, allow group_id to be nullable
        $validatedData = $req->validate([
            'subject_name' => 'required|string|max:255',
            'standard' => 'required|integer',
            'group_id' => 'nullable|integer'
        ]);

        // Extract data safely from the request
        $subject_name = $req->input('subject_name');
        $standard = $req->input('standard');
        $group_id = $req->input('group_id');

        // Prepare data, set group_id to null if empty
        $data = [
            'subject_name' => $subject_name,
            'standard' => $standard,
            'group_id' => !empty($group_id) ? $group_id : null
        ];

        // Check if the subject already exists in the same group
        $result1 = DB::table('subjects')
                ->where('standard', $data['standard'])
                ->where('subject_name', $data['subject_name'])
                ->where('group_id', $data['group_id'])
                ->first();

        if ($result1) {
            return redirect()->back()
                            ->withErrors(['error' => 'This subject already exists in the same group.'])
                            ->withInput();
        } else {
            $result = DB::table('subjects')->insert($data);

            if ($result) {
                return redirect('/create-subject')->with('success', 'Subject created successfully.');
            } else {
                return redirect()->back()
                                ->withErrors(['error' => 'Something went wrong while inserting.'])
                                ->withInput();
            }
        }
    }

    public function retriveSubject() {
        $result['subject'] = DB::table('subjects')
                ->leftJoin('groups', 'subjects.group_id', '=', 'groups.id')
                ->select('subjects.*', 'groups.group_short_name')
                ->orderBy('standard')
                ->get();

        return view('admin.subject.retrive-subject', $result);
    }

    public function editSubject($id) {
        $group = DB::table('groups')
                ->select(DB::raw('MIN(id) as id'), 'group_short_name')
                ->whereNotNull('group_short_name')
                ->groupBy('group_short_name')
                ->orderBy('group_short_name')
                ->get();
        $subject = DB::table('subjects')->where('id', $id)->get();
        return view('admin/subject/edit-subject', compact('group', 'subject'));
    }

    public function deleteSubject($id) {
        $result = DB::table('subjects')->where('id', $id)->delete();
        if ($result) {
            echo json_encode(['status' => 1, 'message' => 'Success']);
        } else {
            echo json_encode(['status' => 0, 'message' => 'failed']);
        }
    }

    public function updateSubject(Request $req) {
        extract($_REQUEST);
        $validatedData = $req->validate([
            'subject_name' => 'required',
            'standard' => 'required'
                ], [
            'student_name.required' => 'Student name is required.',
        ]);

        $id = $req->input('id');
        $data = [
            'subject_name' => $subject_name,
            'standard' => $standard,
            'group_id' => $group_id ?? null
        ];
        $result = DB::table('subjects')->where('id', $id)->update($data);

        if ($result > 0) {
            return redirect('/subject-list')->with('success', 'Subject updated successfully.');
        } elseif ($result === 0) {
            // This means the update didn't affect any rows, possibly because the values are the same
            //echo json_encode(['status' => 0, 'message' => 'No rows were updated. The data might be identical.']);
            return redirect('/subject-list');
        } else {
            return redirect()->back()->withErrors(['error' => 'Failed to update Subject. Please try again.']);
        }
    }

    //department Request $req
    public function createGroup(Request $req) {
        // Validate standard first
        $req->validate([
            'standard' => 'required|integer|min:1|max:12'
        ]);

        $standard = $req->standard;

        // Conditional validation
        if ($standard == 11 || $standard == 12) {
            $req->validate([
                'group_name' => 'required|string|max:255',
                'group_short_name' => 'required|string|max:50'
            ]);
            $data = [
                'standard' => $standard,
                'group_name' => $req->group_name,
                'group_short_name' => $req->group_short_name
            ];
        } else {
            // For standards 1 to 10, group_name and group_short_name can be null or empty
            $data = [
                'standard' => $standard,
                'group_name' => null,
                'group_short_name' => null
            ];
        }

        // Check if group already exists for this standard
        $result1 = DB::table('groups')->where([
                    'standard' => $data['standard'],
                    'group_name' => $data['group_name'],
                    'group_short_name' => $data['group_short_name']
                ])->get();

        if (count($result1) > 0) {
            return redirect()->back()->withErrors(['error' => 'This Group already exists.'])->withInput();
        } else {
            $result = DB::table('groups')->insert($data);
            if ($result) {
                return redirect('/create-group')->with('success', 'Group created successfully.');
            } else {
                return redirect()->back()->withErrors(['error' => 'Something went wrong while inserting'])->withInput();
            }
        }
    }

    public function retriveGroup() {
        $result['groups'] = DB::table('groups')
                ->orderBy('standard')
                ->get(); //->where('id',1)->get()
        return view('admin/group/retrive-group', $result);
    }

    public function editGroup($id) {
        $result['groups'] = DB::table('groups')->where('id', $id)->get();
        return view('admin/group/edit-group', $result);
    }

    public function updateGroup(Request $req) {
        extract($_REQUEST);
        $id = $req->input('id');
        $data = [
            'group_name' => $group_name,
            'group_short_name' => $group_short_name
        ];
        $result = DB::table('groups')->where('id', $id)->update($data);
        if ($result > 0) {
            return redirect('/group-list');
        } elseif ($result === 0) {
            // This means the update didn't affect any rows, possibly because the values are the same
            //echo json_encode(['status' => 0, 'message' => 'No rows were updated. The data might be identical.']);
            return redirect('/group-list');
        } else {
            echo json_encode(['status' => 0, 'message' => 'failed']);
        }
    }

    public function deleteGroup($id) {
        $result = DB::table('groups')->where('id', $id)->delete();
        if ($result) {
            echo json_encode(['status' => 1, 'message' => 'Success']);
        } else {
            echo json_encode(['status' => 0, 'message' => 'failed']);
        }
    }

    //studentform
    public function studentForm() {
        // Get distinct standards with the smallest id for each
        $standards = DB::table('groups')
                ->select(DB::raw('MIN(id) as id'), 'standard')
                ->groupBy('standard')
                ->orderBy('standard')
                ->get();

        // Get distinct group short names with the smallest id for each
        $groupShortNames = DB::table('groups')
                ->select(DB::raw('MIN(id) as id'), 'group_short_name')
                ->whereNotNull('group_short_name')
                ->groupBy('group_short_name')
                ->orderBy('group_short_name')
                ->get();

        return view('admin/student/create-student', compact('standards', 'groupShortNames'));
    }

    public function createStudent(Request $req) {
        $validatedData = $req->validate([
            'enrollno' => 'required|numeric',
            'student_name' => 'required|string|min:3|max:50',
            'mobile' => 'required|numeric|digits:10',
            'dob' => 'required|date|before:today',
            'academic_year' => 'required',
            'gender' => 'required|string'
                ], [
            'enrollno.required' => 'Register number is required.',
            'enrollno.numeric' => 'Register number must be numeric.',
            'student_name.required' => 'Student name is required.',
            'student_name.min' => 'Student name must be at least 3 characters.',
            'student_name.max' => 'Student name cannot exceed 50 characters.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.numeric' => 'Mobile number must be numeric.',
            'mobile.digits' => 'Mobile number must be exactly 10 digits.',
            'dob.required' => 'Date of birth is required.',
            'dob.date' => 'Invalid date format.',
            'dob.before' => 'Date of birth must be before today.',
            'gender.required' => 'Gender is required.'
        ]);

        $data = [
            'enrollno' => $req->input('enrollno'),
            'name' => strtoupper($req->input('student_name')),
            'father_name' => strtoupper($req->input('father_name')),
            'mother_name' => strtoupper($req->input('mother_name')),
            'group_id' => $req->input('group_id'),
            'mobile' => $req->input('mobile'),
            'previous_school' => $req->input('previous_school'),
            'aadhar_number' => $req->input('aadhar_number'),
            'emies_number' => $req->input('emies_number'),
            'communication_address' => $req->input('communication_address'),
            'dob' => date('Y-m-d', strtotime($req->input('dob'))),
            'standard' => $req->input('standard'),
            'section' => $req->input('section'),
            'gender' => $req->input('gender'),
            'join_date' => date('Y-m-d', strtotime($req->input('joined_date'))),
            'email' => $req->input('student_email'),
            'academic_year' => $req->input('academic_year')
        ];

        $Studentexist = DB::table('students')->where('enrollno', $data['enrollno'])->first();
        if ($Studentexist) {
            return redirect()->back()->withErrors(['error' => 'This student already exists with the same register number.'])->withInput();
        } else {
            $result = DB::table('students')->insert($data);
            if ($result) {
                return redirect('/create-student');
            } else {
                return redirect()->back()->withErrors(['error' => 'Something went wrong while inserting.'])->withInput();
            }
        }
    }

    public function retriveStudent(Request $request) {
        $teacher_id = session('user_id'); // or use auth()->id() if using Laravel auth
        // Get teacher's subject allotments
        $allotments = DB::table('subject_allotments')
                ->where('teacher_id', $teacher_id)
                ->select('standard', 'group_name_id', 'section', 'subject_id')
                ->distinct()
                ->get();

        // Get all available standards for this teacher
        $standards = $allotments->pluck('standard')->unique()->sortDesc()->values();
        $default_standard = $standards->first();

        // Get allotments for the default standard
        $default_allotments = $allotments->where('standard', $default_standard);

        // Extract dropdown values
        $sections = $default_allotments->pluck('section')->unique();
        $groups = $default_allotments->pluck('group_name_id')->unique()->filter()->values();
        $subjects = $default_allotments->pluck('subject_id')->unique();

        // Fetch group & subject list for dropdowns
        $group_list = DB::table('groups')->whereIn('id', $groups)->get();
        $subject_list = DB::table('subjects')->whereIn('id', $subjects)->get();

        // Get selected values from request or set defaults
        $selected_standard = $request->input('standard', $default_standard);
        $selected_section = $request->input('section', $sections->first() ?? '');
        $selected_group = $request->input('group', $groups->first() ?? null);
        $selected_subject = $request->input('subject', $subjects->first() ?? null);

        // Build student query
        $query = DB::table('students')
                ->leftJoin('groups', 'students.group_id', '=', 'groups.id')
                ->select('students.*', 'groups.group_short_name')
                ->where('students.standard', $selected_standard)
                ->where('students.section', $selected_section);

        if ($selected_group) {
            $query->where('students.group_id', $selected_group);
        }

        $student = $query->get();

        // Return view with all required data
        return view('admin.student.retrive-student', [
            'standards' => $standards,
            'sections' => $sections,
            'groups' => $group_list,
            'subjects' => $subject_list,
            'student' => $student,
            'selected_standard' => $selected_standard,
            'selected_section' => $selected_section,
            'selected_group' => $selected_group,
            'selected_subject' => $selected_subject,
        ]);
    }

    public function editStudent($id) {
        $result['group'] = DB::table('groups')->get();
        $result['student'] = DB::table('students')->where('id', $id)->get();
        return view('admin/student/edit-student', $result);
    }

    public function updateStudent(Request $req) {
        $validatedData = $req->validate([
            'enrollno' => 'required|numeric',
            'student_name' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits:10',
            'dob' => 'required|date|before:today',
            'joined_at' => 'date|before:today',
            'student_email' => 'required|email', // Added email validation
                ], [
            'enrollno.required' => 'Enrollno number is required.',
            'enrollno.numeric' => 'Enrollno number must be numeric.',
            'enrollno.unique' => 'This enrollno number is already in use.',
            'student_name.required' => 'Student name is required.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.numeric' => 'Mobile number must be numeric.',
            'mobile.digits' => 'Mobile number must be exactly 10 digits.',
            'dob.required' => 'Date of birth is required.',
            'dob.date' => 'Invalid date format.',
            'dob.before' => 'Date of birth must be before today.',
            'joined_at.' => 'Invalid date format.',
            'joined_at.before' => 'Date of joining must be before today.',
            'student_email.required' => 'Email is required.',
            'student_email.email' => 'Invalid email format.'
        ]);

        $id = $req->input('id');

        \Log::info('Updating student with ID: ' . $id, $req->all());

        $existingStudent = DB::table('students')
                ->where('enrollno', $req->input('enrollno'))
                ->where('id', '!=', $id)
                ->first();

        if ($existingStudent) {
            return redirect()->back()->withErrors(['error' => 'This register number is already in use by another student.'])->withInput();
        }

        $data = [
            'enrollno' => $req->input('enrollno'),
            'name' => strtoupper($req->input('student_name')),
            'father_name' => strtoupper($req->input('father_name')),
            'mother_name' => strtoupper($req->input('mother_name')),
            'group_id' => $req->input('group_id'),
            'mobile' => $req->input('mobile'),
            'previous_school' => $req->input('previous_school'),
            'aadhar_number' => $req->input('aadhar_number'),
            'emies_number' => $req->input('emies_number'),
            'communication_address' => $req->input('communication_address'),
            'dob' => $req->input('dob'),
            'standard' => $req->input('standard'),
            'section' => $req->input('section'),
            'gender' => $req->input('gender'),
            'join_date' => $req->input('join_date'), // Use joined_at from request
            'email' => $req->input('student_email'),
            'academic_year' => $req->input('academic_year')
        ];

        $result = DB::table('students')->where('id', $id)->update($data);

        //print_r($result);

        if ($result > 0) {
            return redirect('/student-list')->with('success', 'Student updated successfully.');
        } elseif ($result === 0) {
            // This means the update didn't affect any rows, possibly because the values are the same
            //echo json_encode(['status' => 0, 'message' => 'No rows were updated. The data might be identical.']);
            return redirect('/student-list');
        } else {
            return redirect()->back()->withErrors(['error' => 'Failed to update Subject. Please try again.']);
        }
    }

    public function deleteStudent($id) {
        $result = DB::table('students')->where('id', $id)->delete();
        if ($result) {
            echo json_encode(['status' => 1, 'message' => 'Success']);
        } else {
            echo json_encode(['status' => 0, 'message' => 'failed']);
        }
    }

    //teacher
    public function createTeacher() {
        $designations = DB::table('designations')->get();
        return view('admin.teacher.create-teacher', ['designations' => $designations]);
    }

    public function saveTeacher(Request $req) {
        $validatedData = $req->validate([
            'teacher_name' => 'required|string|min:3|max:255',
            'experience' => 'required|string|min:1|max:50',
            'previous_work_station' => 'required|string|min:3|max:50',
            'qualification' => 'required|string|min:1|max:50',
            'designation' => 'required|int|min:1|max:50',
            'mobile' => 'required|numeric|digits:10',
            'password' => 'required|string|min:6',
            'join_date' => 'required|date',
            'teacher_email' => 'required|email'
        ]);

        // Insert into teachers table
        $teacher_id = DB::table('teachers')->insertGetId([
            'name' => strtoupper($req->teacher_name),
            'mobile' => $req->mobile,
            'experience' => $req->experience,
            'previous_work_station' => $req->previous_work_station,
            'qualification' => $req->qualification,
            'designation_id' => $req->designation,
            'join_date' => date('Y-m-d', strtotime($req->input('join_date'))),
            'email' => $req->teacher_email,
            'password' => sha1($req->password), // ✅ secure hashing
        ]);

        return redirect('/create-teacher')->with('success', 'Teacher created successfully.');
    }

    public function retriveTeacher(Request $request) {
        $designation_id = $request->input('designation');

        $teacher = collect(); // empty collection by default
        if ($designation_id) {
            $teacher = DB::table('teachers')
                    ->leftJoin('designations', 'teachers.designation_id', '=', 'designations.id')
                    ->select('teachers.*', 'designations.designation as designation_name')
                    ->where('teachers.designation_id', $designation_id)
                    ->get();
        }

        $designations = DB::table('designations')->get();

        return view('admin.teacher.retrive-teacher', compact('teacher', 'designations', 'designation_id'));
    }

    public function deleteTeacher($id) {
        $result1 = DB::table('teachers')->where('id', $id)->delete();
        $result2 = DB::table('subject_allotments')->where('teacher_id', $id)->delete();
        if ($result1 && $result2) {
            return response()->json(['status' => 1, 'message' => 'Teacher deleted successfully']);
        } else {
            return response()->json(['status' => 0, 'message' => 'Failed to delete teacher']);
        }
    }

    public function editTeacher($id) {
        $teacher = DB::table('teachers')->where('id', $id)->first();
        $designations = DB::table('designations')->get();
        return view('admin.teacher.edit-teacher', compact('teacher', 'designations'));
    }

    public function updateTeacher(Request $req) {
        extract($_REQUEST);

        $validatedData = $req->validate([
            'experience' => 'required|string|min:1|max:50',
            'previous_work_station' => 'required|string|min:3|max:50',
            'qualification' => 'required|string|min:1|max:50',
            'designation' => 'required|integer',
            'mobile' => 'required|numeric|digits:10'
                ], [
            // Custom error messages
            'name.min' => 'Teacher name must be at least 3 characters.',
            'name.max' => 'Teacher name cannot exceed 255 characters.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.numeric' => 'Mobile number must be numeric.',
            'mobile.digits' => 'Mobile number must be exactly 10 digits.',
            'experience.required' => 'experience name is required.',
        ]);
        $id = $req->input('id');
        $data = [
            'name' => strtoupper($teacher_name),
            'mobile' => $mobile,
            'experience' => $experience,
            'previous_work_station' => $previous_work_station,
            'qualification' => $qualification,
            'designation_id' => $designation,
            'join_date' => date('Y-m-d', strtotime($req->input('join_date'))),
            'email' => $teacher_email,
        ];
        $result = DB::table('teachers')->where('id', $id)->update($data);

        if ($result > 0) {
            return redirect('/teacher-list')->with('success', 'Teacher updated successfully.');
        } elseif ($result === 0) {
            // This means the update didn't affect any rows, possibly because the values are the same
            //echo json_encode(['status' => 0, 'message' => 'No rows were updated. The data might be identical.']);
            return redirect('/teacher-list');
        } else {
            return redirect()->back()->withErrors(['error' => 'Failed to update Subject. Please try again.']);
        }
    }

    public function subjectAllotment() {
        // Load all subjects
        $subjects = DB::table('subjects')
                ->selectRaw('MIN(id) as id,subject_name')
                ->groupBy('subject_name')
                ->get();
        $groups = DB::table('groups')
                ->selectRaw('MIN(id) as id, group_short_name')
                ->where('group_short_name', '!=', '')
                ->groupBy('group_short_name')
                ->orderBy('group_short_name')
                ->get();
        $academic_year = DB::table('students')
                ->select('academic_year')
                ->distinct()
                ->get();
        // Get distinct shortnames with their IDs
        $classes = DB::table('groups')
                ->select('standard')
                ->distinct()
                ->orderBy('standard')
                ->get();
        $teachers = DB::table('teachers')
                ->whereIn('designation_id', [2, 1])
                ->get();

        return view('admin.teacher.subject-allotment', compact('subjects', 'groups', 'classes', 'teachers', 'academic_year'));
    }

//   public function saveSubjectAllotments(Request $req) {
//    
//    $teacher_id = $req->teacher_id;
//    $class_ids = $req->class_ids;
//    $shortname_ids = $req->shortname_ids;
//    $subject_ids = $req->subject_ids;
//    $sections = $req->sections;
//    $teacher_types = $req->teacher_types;
//    $academic_years = $req->academic_years;
//    $allotment_ids = $req->allotment_ids ?? [];
//
//    for ($i = 0; $i < count($class_ids); $i++) {
//        $allotment_id = $allotment_ids[$i] ?? null;
//
//        // Skip existing allotments
//        if ($allotment_id) continue;
//
//        $class_id = (int) $class_ids[$i];
//        $shortname_id = $class_id > 10 ? ($shortname_ids[$i] ?? null) : null;
//
//        DB::table('subject_allotments')->insert([
//            'teacher_id' => $teacher_id,
//            'standard' => $class_id,
//            'group_name_id' => $shortname_id,
//            'subject_id' => $subject_ids[$i],
//            'section' => $sections[$i],
//            'teacher_type' => $teacher_types[$i],
//            'academic_year' => $academic_years[$i],
//        ]);
//    }
//
//    return redirect('/create-subject-allotment')->with('success', 'New subject allotments saved successfully.');
//}

    public function saveSubjectAllotments(Request $req) {
        $teacher_id = $req->teacher_id;
        $class_ids = $req->class_ids;
        $shortname_ids = $req->shortname_ids ?? [];
        $subject_ids = $req->subject_ids;
        $sections = $req->sections;
        $teacher_types = $req->teacher_types;
        $academic_years = $req->academic_years;
        $allotment_ids = $req->allotment_ids ?? [];

        for ($i = 0; $i < count($class_ids); $i++) {
            $class_id = (int) $class_ids[$i];
            $subject_id = $subject_ids[$i] ?? null;

            // Skip if no subject selected
            if (!$subject_id)
                continue;

            // Only classes 11 & 12 have group
            $shortname_id = ($class_id == 11 || $class_id == 12) ? ($shortname_ids[$i] ?? null) : null;

            $data = [
                'standard' => $class_id,
                'group_name_id' => $shortname_id,
                'subject_id' => $subject_id,
                'section' => $sections[$i],
                'teacher_type' => $teacher_types[$i],
                'academic_year' => $academic_years[$i],
            ];

            if (!empty($allotment_ids[$i])) {
                // Existing allotment → update
                DB::table('subject_allotments')
                        ->where('id', $allotment_ids[$i])
                        ->update($data);
            } else {
                // New allotment → insert
                $data['teacher_id'] = $teacher_id;
                DB::table('subject_allotments')->insert($data);
            }
        }

        return redirect()->back()->with('success', 'Subject allotments saved successfully.');
    }

    public function getTeacherAllotments($teacherId) {
        $allotments = DB::table('subject_allotments as sa')
                ->leftJoin('subjects as s', 'sa.subject_id', '=', 's.id')
                ->leftJoin('groups as g', 'sa.group_name_id', '=', 'g.id')
                ->select(
                        'sa.id',
                        'sa.standard',
                        'sa.group_name_id',
                        'sa.subject_id',
                        'sa.section',
                        'sa.teacher_type',
                        'sa.academic_year',
                        's.subject_name',
                        'g.group_short_name'
                )
                ->where('sa.teacher_id', $teacherId)
                ->get();

        return response()->json($allotments);
    }

    public function subjectAllotmentList($teacher_id) {
        $allotments = DB::table('subject_allotments as sa')
                ->join('teachers as t', 'sa.teacher_id', '=', 't.id')
                ->leftJoin('subjects as s', 'sa.subject_id', '=', 's.id') // join by subject_id
                ->leftJoin('groups as g', 'sa.group_name_id', '=', 'g.id')
                ->select(
                        'sa.id',
                        'sa.teacher_id',
                        't.name as teacher_name',
                        'sa.standard',
                        's.subject_name',
                        'g.group_short_name',
                        'sa.section',
                        'sa.teacher_type',
                        'sa.academic_year'
                )
                ->when($teacher_id, function ($query) use ($teacher_id) {
                    $query->where('sa.teacher_id', $teacher_id);
                })
                ->orderBy('t.name')
                ->get();

        // Debug
        // dd($allotments);

        return view('admin.teacher.list-subject-allotment', compact('allotments'));
    }

// Controller
    // Controller
    public function subjectAllotmentEdit($teacherId) {
        // Get the teacher's details
        $teacher = DB::table('teachers')->where('id', $teacherId)->first();

        // Load existing allotments for this teacher
        $allotments = DB::table('subject_allotments')
                ->where('teacher_id', $teacherId)
                ->get();

        // Get list of all subjects
        $subjects = DB::table('subjects')->get();

        // Get distinct classes (standards) for the Class dropdown
        $class_list = DB::table('groups')
                ->select('standard')
                ->distinct()
                ->orderBy('standard')
                ->get();
        $subjects = DB::table('subjects')
                ->selectRaw('MIN(id) as id,subject_name')
                ->groupBy('subject_name')
                ->get();
        $groups = DB::table('groups')
                ->selectRaw('MIN(id) as id, group_short_name')
                ->where('group_short_name', '!=', '')
                ->groupBy('group_short_name')
                ->orderBy('group_short_name')
                ->get();
        // Get list of groups for the Group Name dropdown


        return view('admin.teacher.edit-subject-allotment', compact('teacher', 'allotments', 'subjects', 'groups', 'class_list'));
    }

    public function subjectAllotmentUpdate(Request $req) {

        try {
            $teacherId = $req->teacher_id;
            $allotment_ids = $req->allotment_ids ?? [];
            $class_ids = $req->class_ids;
            $shortname_ids = $req->shortname_ids ?? [];
            $subject_ids = $req->subject_ids;
            $sections = $req->sections;
            $teacher_types = $req->teacher_types;
            $academic_years = $req->academic_years;

            for ($i = 0; $i < count($class_ids); $i++) {
                $class_id = (int) $class_ids[$i];
                $shortname_id = null;
                if ($class_id == 11 || $class_id == 12) {
                    $shortname_id = isset($shortname_ids[$i]) && $shortname_ids[$i] != '' ? $shortname_ids[$i] : null;
                }

                $allotment_id = $allotment_ids[$i] ?? null;

                if ($allotment_id) {
                    $data = [
                        'standard' => $class_id,
                        'subject_id' => $subject_ids[$i],
                        'group_name_id' => $shortname_id, // Correctly updated regardless of class
                        'section' => $sections[$i],
                        'teacher_type' => $teacher_types[$i],
                        'academic_year' => $academic_years[$i],
                        'academic_year' => $academic_years[$i],
                    ];

                    // Update by allotment ID, so group name will also be updated correctly

                    DB::table('subject_allotments')
                            ->where('id', $allotment_id)
                            ->update($data);
                } else {
                    // Insert new allotment
                    DB::table('subject_allotments')->insert([
                        'teacher_id' => $teacherId,
                        'standard' => $class_id,
                        'subject_id' => $subject_ids[$i],
                        'group_name_id' => $shortname_id,
                        'section' => $sections[$i],
                        'teacher_type' => $teacher_types[$i],
                        'academic_year' => $academic_years[$i],
                    ]);
                }
            }

            if ($req->ajax() || $req->wantsJson()) {
                return response()->json([
                            'status' => 'success',
                            'message' => 'Subject allotments updated successfully.',
                            'redirect' => url("/subject-allotment-list/{$teacherId}")
                ]);
            }

            return redirect("/subject-allotment-list/{$teacherId}")->with('success', 'Subject allotments updated successfully.');
        } catch (\Exception $e) {
            if ($req->ajax() || $req->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
            }
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }

    public function subjectAllotmentDelete($id) {
        try {
            DB::table('subject_allotments')->where('id', $id)->delete();

            return response()->json([
                        'status' => 'success',
                        'message' => 'Allotment deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                        'status' => 'error',
                        'message' => 'An error occurred: ' . $e->getMessage()
                            ], 500);
        }
    }

}
