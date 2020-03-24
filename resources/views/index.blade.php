@extends('layout')

@section('title',"Dashboard")

@section('content')
            <div class="col-md-2">
                
                <div class="block block-drop-shadow">
                    <div class="user bg-default bg-light-rtl">
                        <div class="info">                                                                                
                            <a href="#" class="informer informer-three">
                                <span>{{$user->fname}}</span>
									{{$user->lname}}
                            </a>                            
                            <a href="#" class="informer informer-four">
                                <span>Admin</span>
                                Role
                            </a>                                                        
                            <img src="img/icon.png" class="img-circle img-thumbnail"/>
                        </div>
                    </div>
                    <div class="content list-group list-group-icons">
                        <a href="{{url('logout')}}" class="list-group-item"><span class="icon-off"></span>Logout<i class="icon-angle-right pull-right"></i></a>
                    </div>
                </div> 
                
               
                <div class="block block-drop-shadow">                    
                    <div class="head bg-dot20">
                        <h2>Total profit (&#8358;)</h2>
                        <div class="side pull-right">               
                            <ul class="buttons">                                
                                <li><a href="#"><span class="icon-cogs"></span></a></li>
                            </ul>
                        </div>
                        <div class="head-subtitle">Total amount generated from revenue </div>                        
                        <div class="head-panel tac" style="line-height: 0px;">
                            <div class="knob">
                                <input type="text" data-fgColor="#3F97FE" data-min="0" data-max="1024" data-width="100" data-height="100" value="0" data-readOnly="true"/>
                            </div>                              
                        </div>
                        <div class="head-panel nm">
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="hp-main">Total profit today</span>
                                <span class="hp-sm">Amount: &#8358;0 </span>
                            </div>                 
                            <div class="hp-info hp-simple pull-left hp-inline">
                                <span class="hp-main">Total profit this month</span>
                                 <span class="hp-sm">Amount: &#8358;0 </span>
                            </div>                 
                        </div>                        
                    </div>                    
                    
                </div>                
                
            </div>
            
            <div class="col-md-5">
               <div class="block block-drop-shadow">                    
                    <div class="head bg-dot20">
                        <h2>Total rides</h2>
                        <div class="side pull-right">               
                            <ul class="buttons">                                
                                <li><a href="#"><span class="icon-cogs"></span></a></li>
                            </ul>
                        </div>
                        <div class="head-subtitle">Total rides on the app</div>                        
                        <div class="head-panel nm tac" style="line-height: 0px;">
                            <div class="knob">
                                <input type="text" data-fgColor="#3F97FE" data-min="0" data-max="100" data-width="100" data-height="100" value="0" data-readOnly="true"/>
                            </div>                              
                        </div>
                        <div class="head-panel nm">
                            <div class="hp-info hp-simple pull-left">
                                <span class="hp-main">Today's rides</span>
                                <span class="hp-sm">0</span>                                
                            </div>
                            <div class="hp-info hp-simple pull-right">
                                <span class="hp-main">Total rides this month</span>
                                <span class="hp-sm">0</span>                                
                            </div>                            
                        </div>                        
                    </div>                    
                    
                </div>  
                <div class="block block-drop-shadow">                    
                      <div class="head bg-dot20">
                        <h2>Total passengers</h2>
                        <div class="side pull-right">               
                            <ul class="buttons">                                
                                <li><a href="#"><span class="icon-cogs"></span></a></li>
                            </ul>
                        </div>
                        <div class="head-subtitle">Total passengers carried</div>                        
                        <div class="head-panel nm tac" style="line-height: 0px;">
                            <div class="knob">
                                <input type="text" data-fgColor="#3F97FE" data-min="0" data-max="100" data-width="100" data-height="100" value="0" data-readOnly="true"/>
                            </div>                              
                        </div>
                        <div class="head-panel nm">
                            <div class="hp-info hp-simple pull-left">
                                <span class="hp-main">Today's passengers</span>
                                <span class="hp-sm">0</span>                                
                            </div>
                            <div class="hp-info hp-simple pull-right">
                                <span class="hp-main">Total passengers this month</span>
                                <span class="hp-sm">0</span>                                
                            </div>                            
                        </div>                        
                    </div>                    
                                       
                    
                </div>   				
              

            </div> 
			<div class="col-md-5">
               <div class="block block-drop-shadow">                    
                        <div class="head bg-dot20">
                        <h2>Total drivers</h2>
                        <div class="side pull-right">               
                            <ul class="buttons">                                
                                <li><a href="#"><span class="icon-cogs"></span></a></li>
                            </ul>
                        </div>
                        <div class="head-subtitle">Total drivers registered on the app</div>                        
                        <div class="head-panel nm tac" style="line-height: 0px;">
                            <div class="knob">
                                <input type="text" data-fgColor="#3F97FE" data-min="0" data-max="100" data-width="100" data-height="100" value="0" data-readOnly="true"/>
                            </div>                              
                        </div>
                        <div class="head-panel nm">
                            <div class="hp-info hp-simple pull-left">
                                <span class="hp-main">Registered drivers</span>
                                <span class="hp-sm">0</span>                                
                            </div>
                            <div class="hp-info hp-simple pull-right">
                                <span class="hp-main">Suspended drivers</span>
                                <span class="hp-sm">0</span>                                
                            </div>                            
                        </div>                        
                    </div>                    
                                       
                    
                </div>  
                <div class="block block-drop-shadow">                    
                    <div class="head bg-dot20">
                        <h2>Sometitle</h2>
                        <div class="side pull-right">               
                            <ul class="buttons">                                
                                <li><a href="#"><span class="icon-cogs"></span></a></li>
                            </ul>
                        </div>
                        <div class="head-subtitle">Lorem ipsum dolor, subtitle title</div>                        
                        <div class="head-panel nm tac" style="line-height: 0px;">
                            <div class="knob">
                                <input type="text" data-fgColor="#3F97FE" data-min="0" data-max="100" data-width="100" data-height="100" value="80" data-readOnly="true"/>
                            </div>                              
                        </div>
                        <div class="head-panel nm">
                            <div class="hp-info hp-simple pull-left">
                                <span class="hp-main">Information</span>
                                <span class="hp-sm">More information</span>                                
                            </div>
                            <div class="hp-info hp-simple pull-right">
                                <span class="hp-main">Information</span>
                                <span class="hp-sm">More information</span>                                
                            </div>                            
                        </div>                        
                    </div>                    
                    
                </div>   				
              

            </div>
@stop