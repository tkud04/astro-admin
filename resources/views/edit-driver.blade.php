@extends('layout')

@section('title',"Edit Driver Info")

@section('content')
			<div class="col-md-12">
			 <?php
			   $uu = url('edit-driver');
				$fname = $driver['fname'];
				$lname = $driver['lname'];
				$email = $driver['email'];
				$phone = $driver['phone'];
				$status = $driver['status'];
				$created_at = $driver['date'];
				$ss = ($status == "enabled") ? "success" : "danger";
			 ?>
			 
			<form method="post" action="{{$uu}}">
				{!! csrf_field() !!}
				<input type="hidden" name="xf" value="{{$xf}}"/>
                <div class="block">
                    <div class="header">
                        <h2>Edit information about an existing driver</h2>
                    </div>
                    <div class="content controls">
                        <div class="form-row">
                            <div class="col-md-3">First name:</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="fname" placeholder="First name" value="{{$fname}}"/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Last name:</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="lname" placeholder="Last name" value="{{$lname}}"/></div>
                        </div> 
						<div class="form-row">
                            <div class="col-md-3">Email address:</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="email" placeholder="Email address" value="{{$email}}"/></div>
                        </div> 
						<div class="form-row">
                            <div class="col-md-3">Phone number:</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="phone" placeholder="Phone number" value="{{$phone}}"/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Status:</div>
                            <div class="col-md-9">
							 <select class="form-control" name="status">
							   <option value="none">Set status</option>
							   <option value="enabled">Enabled</option>
							   <option value="pending">Pending</option>
							   <option value="suspended">Suspended</option>
							 </select>
							</div>
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