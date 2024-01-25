@extends('layouts.dashboard') @section('content')
<div class="page-wrapper">
	<div class="content">
		<div class="page-header">
			<div class="page-title">
				<h4>Profile</h4>
				<h6>User Profile</h6> </div>
		</div>
        <!-- main alert @s -->
        @include('partials.alerts')
        <!-- main alert @e -->

		<div class="card">
			<div class="card-body">
				<div class="profile-set">
                    <div class="profile-head"> </div>
                    {!! Form::model($user, ['route' => $section->route, 'class' => 'form-validate', 'files' => true, 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) !!}
                            @method($section->method)
					<div class="profile-top">
						<div class="profile-content">
							<div class="profile-contentimg"> <img src="{{ asset($user->profile_picture)}}" alt="img" id="blah">
								<div class="profileupload">
									<input type="file" id="imgInp" name="profile" >
									<a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/edit-set.svg')}}" alt="img"></a>
								</div>
							</div>
							<div class="profile-contentname">
								<h2>{{ $user->name }} </h2>
								<h4>Updates Your Photo and Personal Details.</h4> </div>
						</div>
                        <div class="ms-auto">
                        <button class="btn btn-submit me-2" type="submit" >Save</button>
                        <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a> </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                {!! Form::model($user, ['route' => $section->route, 'class' => 'form-validate', 'files' => true, 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) !!}
                            @method($section->method)
				<div class="row">



                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="name" placeholder="William" value="{{ ($user->name) ? $user->name : ''   }}"> </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" style="background: #ccc; " name="email" readonly value="{{ ($user->email) ? $user->email : ''   }}"> </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" name="password" class="pass-input" value=""> <span class="fas toggle-password fa-eye-slash"></span> </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text"  name="phone" placeholder="Enter Phone Number" value="{{ ($user->phone) ? $user->phone : ''   }}"> </div>
                        </div>
                        <div class="col-12">
                                <button class="btn btn-submit me-2" type="submit" >Submit</button>
                                <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                        </div>

                </div>
                {!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
</div> @endsection
