<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="assets/"
    data-template="vertical-menu-template-free"
    >
    <head>
        <title>Subject List</title>
        @include('admin.includes.formcss')
    </head>

    <body>
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                @include('admin.includes.menu')

                <div class="layout-page">
                    @include('admin.includes.nav')

                    <div class="content-wrapper">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <h4 class="fw-bold py-3 mb-2">Subject List</h4>

                            <div class="card">
                                <h5 class="card-header">Subjects by Class</h5>
                                <div class="card-body">

                                    <div class="accordion" id="classAccordion">
                                        {{-- Loop through classes 1 to 10 --}}
                                        @for($i = 1; $i <= 10; $i++)
                                        @php
                                        $classSubjects = $subject->where('standard', $i);
                                        @endphp
                                        <div class="accordion-item mb-2">
                                            <h2 class="accordion-header" id="heading{{$i}}">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">
                                                    Class {{$i}}
                                                </button>
                                            </h2>
                                            <div id="collapse{{$i}}" class="accordion-collapse collapse" aria-labelledby="heading{{$i}}" data-bs-parent="#classAccordion">
                                                <div class="accordion-body">
                                                    @if($classSubjects->count() > 0)
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th> <a class="btn btn-sm btn-primary" href="{{url('/create-subject')}}">
                                                            <i class="bx bx-plus-circle me-1" ></i> Add New
                                                        </a></th>
                                                                    <th>Subject</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($classSubjects as $d)
                                                                <tr>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                                            </button>
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item" href="{{url('/edit-subject/'.$d->id)}}">
                                                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                                                </a>
                                                                                <a class="dropdown-item cursor-pointer" data-id="{{$d->id}}" onclick="return deleteSubject(this);">
                                                                                    <i class="bx bx-trash me-1"></i> Delete
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>{{$d->subject_name}}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    @else
                                                    <p class="text-muted mb-0">No subjects available for Class {{$i}}.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endfor

                                        {{-- For Classes 11 and 12 (Group-wise) --}}
                                        @foreach([11, 12] as $class)
                                        <div class="accordion-item mb-2">
                                            <h2 class="accordion-header" id="heading{{$class}}">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$class}}" aria-expanded="false" aria-controls="collapse{{$class}}">
                                                    Class {{$class}} 
                                                </button>
                                            </h2>
                                            <div id="collapse{{$class}}" class="accordion-collapse collapse" aria-labelledby="heading{{$class}}" data-bs-parent="#classAccordion">
                                                <div class="accordion-body">
                                                    @php
                                                    $groups = $subject->where('standard', $class)->groupBy('group_short_name');
                                                    @endphp
                                                    @if($groups->count() > 0)
                                                    <div class="accordion" id="groupAccordion{{$class}}">
                                                        @foreach($groups as $groupName => $groupSubjects)
                                                        <div class="accordion-item mb-1">
                                                            <h2 class="accordion-header" id="groupHeading{{$class}}{{$loop->index}}">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#groupCollapse{{$class}}{{$loop->index}}" aria-expanded="false" aria-controls="groupCollapse{{$class}}{{$loop->index}}">
                                                                    {{$groupName ?: 'General'}}
                                                                </button>
                                                            </h2>
                                                            <div id="groupCollapse{{$class}}{{$loop->index}}" class="accordion-collapse collapse" aria-labelledby="groupHeading{{$class}}{{$loop->index}}" data-bs-parent="#groupAccordion{{$class}}">
                                                                <div class="accordion-body">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th > <a class="btn btn-sm btn-primary" href="{{url('/create-subject')}}">
                                                                                            <i class="bx bx-plus-circle me-1" ></i> Add New
                                                                                        </a></th>
                                                                                    <th>Subject</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($groupSubjects as $d)
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="dropdown">
                                                                                            <button class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                                                            </button>
                                                                                            <div class="dropdown-menu">
                                                                                                <a class="dropdown-item" href="{{url('/edit-subject/'.$d->id)}}">
                                                                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                                                                </a>
                                                                                                <a class="dropdown-item cursor-pointer" data-id="{{$d->id}}" onclick="return deleteSubject(this);">
                                                                                                    <i class="bx bx-trash me-1"></i> Delete
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>{{$d->subject_name}}</td>
                                                                                </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @else
                                                    <p class="text-muted mb-0">No subjects available for Class {{$class}}.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('admin.includes.footer')
                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
            </div>

            <div class="layout-overlay layout-menu-toggle"></div>

            @include('admin.includes.floatmsg')
            @include('admin.includes.formjs')
    </body>
</html>
