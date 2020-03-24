@extends('layout')

@section('title',"Add New Driver")

@section('content')
			<div class="col-md-12">
			<form method="post" action="{{url('add-driver')}}">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>Add new driver to the system</h2>
                    </div>
                    <div class="content controls">
                        <div class="form-row">
                            <div class="col-md-3">First name:</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="fname" placeholder="First name"/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Last name:</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="lname" placeholder="Last name"/></div>
                        </div> 
						<div class="form-row">
                            <div class="col-md-3">Email address:</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="email" placeholder="Email address"/></div>
                        </div> 
						<div class="form-row">
                            <div class="col-md-3">Phone number:</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="phone" placeholder="Phone number"/></div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3">Password:</div>
                            <div class="col-md-9"><input type="password" class="form-control" name="pass" placeholder="Password"/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Confirm password:</div>
                            <div class="col-md-9"><input type="password" class="form-control" name="pass_confirmation" placeholder="Confirm password"/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
							  <center>
							    <button type="submit" class="btn btn-default btn-block btn-clean">Submit</button>
							  </center>
							</div>
                            <div class="col-md-4"></div>							
                        </div>
                                              
                    </div>
                </div>  
            </form>				
            </div>
@stop