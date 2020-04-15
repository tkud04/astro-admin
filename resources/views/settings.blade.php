@extends('layout')

@section('title',"Settings")

@section('content')
			<div class="col-md-12">
			 <?php
			   $uu = url('settings');
				$bp = $settings['base_price'];
				$cs = $settings['surge'];
				
			 ?>
			 
			<form method="post" action="{{$uu}}" enctype="multipart/form-data">
				{!! csrf_field() !!}
				<input type="hidden" name="xf" value="{{$xf}}"/>
                <div class="block">
                    <div class="header">
                        <h2>Site settings</h2>
                    </div>
                    <div class="content controls">
                        <div class="form-row">
                            <div class="col-md-3">Base price(&#8358;)</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="base_price" placeholder="Base price for all rides" value="{{$bp}}"/></div>
                        </div>
						<div class="form-row">
                            <div class="col-md-3">Current surge:</div>
                            <div class="col-md-9"><input type="text" class="form-control" name="surge" placeholder="Current surge for all rides" value="{{$lname}}"/></div>
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