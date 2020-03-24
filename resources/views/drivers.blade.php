@extends('layout')

@section('title',"Drivers")

@section('content')
			<div class="col-md-12">
				{!! csrf_field() !!}
                <div class="block">
                    <div class="header">
                        <h2>List of drivers on the system</h2>
                    </div>
                    <div class="content">
                       <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper" role="grid">
					     
                        <table cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped sortable">
                            <thead>
                                <tr>
                                    <th width="20%">Name</th>
                                    <th width="20%">Phone</th>
                                    <th width="20%">E-mail</th>
                                    <th width="20%">Status</th>                                                                       
                                    <th width="20%">Actions</th>                                                                       
                                </tr>
                            </thead>
                            <tbody>
							   @foreach($drivers as $d)
							   <?php
							   $status = $d['status'];
							   $ss = ($status == "enabled") ? "success" : "danger";
							   ?>
                                <tr>
                                    <td>{{$d['fname']." ".$d['lname']}}</td>
                                    <td>{{$d['phone']}}</td>
                                    <td>{{$d['email']}}</td>
                                    <td><span class="driver-status label label-{{$ss}}">{{$status}}</span></td>                                                                     
                                    <td>
									  <?php
									   $uu = url('driver')."?id=".$d['id'];
									   
									  ?>
									  <a href="{{$uu}}" class="btn btn-primary">View</button>									  
									</td>                                                                     
                                </tr>
                               @endforeach                       
                            </tbody>
                        </table>                                        

                    </div>
                </div>  
            </div>				
           </div>
@stop