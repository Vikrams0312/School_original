<!DOCTYPE html>
<!-- beautify ignore:start -->
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="assets/"
    data-template="vertical-menu-template-free"
    >
    <head>
        <title>Edit Subject</title>
        @include('admin.includes.formcss')
    </head>

    <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <!-- Menu -->
                @include('admin.includes.menu')
                <!-- / Menu -->
                <!-- Layout container -->
                <div class="layout-page">
                    <!-- Navbar -->
                    @include('admin.includes.nav')
                    <!-- / Navbar -->
                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <h4 class="fw-bold py-1 mb-1"><span class="text-muted fw-light">Form/</span>Subject</h4>
                            
                            <hr class="my-2" />
                            <form method="post" action="{{url('/update-subject')}}">
                                <!-- Basic Layout & Basic with Icons -->
                                <div class="row">
                                    <!-- Basic with Icons -->
                                    <div class="col-xxl">
                                        <div class="card mb-4">
                                            <div class="card-header d-flex align-items-center justify-content-between">
                                                <h5 class="mb-0">Assign Subject</h5>
                                            </div>
                                            <div class="card-body">
                                                @csrf
                                                @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif
                                                @php 
                                                ($d = $subject[0]);
                                                @endphp
                                                <div class="row mb-3 d-none">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Id</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                value="{{$d->id}}"
                                                                name="id"
                                                                readonly
                                                                aria-label="John Doe"
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                />
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Standard</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <select type="text" class="form-control" name="standard" required=""/>                                                                                                                      
                                                            <option value="LKG" {{ $d->standard == 'LKG' ? 'selected' : '' }}>LKG</option>
                                                            <option value="UKG" {{ $d->standard == 'UKG' ? 'selected' : '' }}>UKG</option>                                                            
                                                            @php                                                                
                                                            $numbers = range(1, 12);
                                                            @endphp
                                                            @foreach ($numbers as $standard)
                                                            <option value="{{ $standard }}" {{ $d->standard == $standard ? 'selected' : '' }}>
                                                                {{ $standard }}
                                                            </option>
                                                            @endforeach                                                            
                                                            </select>
                                                        </div>
                                                        @error('standard')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Group</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <select type="text" class="form-control" name="group_id" />
                                                            @foreach($group as $dt)
                                                            @if ($d->group_id == $dt->id)
                                                            <option value="{{$d->group_id}}" selected >{{$dt->group_short_name}}</option>
                                                            @else                                                         
                                                            <option value="{{$dt->id}}">{{$dt->group_short_name}}</option> 
                                                            @endif
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                        @error('group_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Subject Name</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="subject_name"
                                                                required
                                                                value="{{$d->subject_name}}"
                                                                placeholder="Enter Subject name "
                                                                aria-label="Enter Subject name "
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                autofocus="true"
                                                                />
                                                        </div>
                                                        @error('subject_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>                                                
                                                <div class="row justify-content-end">
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-info">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                        <!-- / Content -->
                        <!-- Footer -->
                        @include('admin.includes.footer')
                        <!-- / Footer -->
                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->

        @include('admin.includes.floatmsg')

        <!-- Core JS -->
        @include('admin.includes.formjs')
    </body>
</html>
