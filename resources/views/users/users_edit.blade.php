@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
            	<div class="nk-block nk-block-lg">
				    <div class="card card-bordered">
				        <div class="card-inner">
				            <div class="card-head">
				                <h5 class="card-title font-neue">თანამშრომლის პროფილის რედატირება</h5>
				            </div>
				            <ul class="nav nav-tabs font-neue">
							    <li class="nav-item">
							        <a class="nav-link active" data-toggle="tab" href="#tabItem1">პირადი ინფორმაცია</a>
							    </li>
							    <li class="nav-item">
							        <a class="nav-link" data-toggle="tab" href="#tabItem2">სამუშაო აღწერა</a>
							    </li>
							    <li class="nav-item">
							        <a class="nav-link" data-toggle="tab" href="#tabItem3">საკონტაქტო ინფორმაცია</a>
							    </li>
							</ul>
				            <form id="user_form">
								<div class="tab-content m-0">
								    <div class="tab-pane active m-3" id="tabItem1">
						                <div class="row g-4">
						                    <div class="col-lg-6">
						                        <div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_name">სახელი</label>
						                            <div class="form-control-wrap">
						                                <input type="text" class="form-control error-input" id="user_name" name="user_name" value="{{ $user_data->name }}">
						                            </div>
						                        </div>
						                    </div>
						                    <div class="col-lg-6">
						                        <div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_lastname">გვარი</label>
						                            <div class="form-control-wrap">
						                                <input type="text" class="form-control error-input" id="user_lastname" name="user_lastname" value="{{ $user_data->lastname }}">
						                            </div>
						                        </div>
						                    </div>
						                    <div class="col-lg-6">
						                        <div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_bday">დაბადების თარიღი</label>
						                            <div class="form-control-wrap">
						                                <input type="date" class="form-control error-input" id="user_bday" name="user_bday" value="{{ $user_data->bday }}">
						                            </div>
						                        </div>
						                    </div>
						                    <div class="col-lg-6">
						                        <div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_personal_id">პირადი ნომერი</label>
						                            <div class="form-control-wrap">
						                                <input type="number" class="form-control error-input" id="user_personal_id" name="user_personal_id" value="{{ $user_data->personal_id }}">
						                            </div>
						                        </div>
						                    </div>
						                    <div class="col-lg-6">
						                        <div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_address_legal">იურიდიული მისამართი</label>
						                            <div class="form-control-wrap">
						                                <input type="text" class="form-control error-input" id="user_address_legal" name="user_address_legal">
						                            </div>
						                        </div>
						                    </div>
						                    <div class="col-lg-6">
						                        <div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_address">ფაქტობრივი მისამართი</label>
						                            <div class="form-control-wrap">
						                                <input type="text" class="form-control error-input" id="user_address" name="user_address" value="{{ $user_data->address }}">
						                            </div>
						                        </div>
						                    </div>
						                    <div class="col-lg-6">
						                        <div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_phone">ტელეფონის ნომერი</label>
						                            <div class="form-control-wrap">
						                                <input type="phone" class="form-control error-input" id="user_phone" name="user_phone" value="{{ $user_data->phone }}">
						                            </div>
						                        </div>
						                    </div>
						                    <div class="col-lg-6">
						                        <div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_email">ელ-ფოსტა</label>
						                            <div class="form-control-wrap">
						                                <input type="email" class="form-control error-input" id="user_email" name="user_email" value="{{ $user_data->email }}">
						                            </div>
						                        </div>
						                    </div>
						                </div>
						                <input type="hidden" name="user_id" id="user_id" value="{{ $user_data->id }}">
								    </div>
								    <div class="tab-pane p-0 m-3" id="tabItem2">
							        	<table class="table table-ulogs">
	                                        <thead class="thead-light">
	                                            <tr>
	                                                <th class="tb-col-time font-neue px-2"><span class="overline-title">პოზიციის დასახელება</span></th>
	                                                <th class="tb-col-time font-neue"><span class="overline-title">ფილიალი / განყოფილება</span></th>
	                                                <th class="tb-col-time font-neue"><span class="overline-title">ხელშეკრულების ტიპი / ანაზღაურების ტიპი / ანაზღაურება</span></th>
	                                                <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
	                                            </tr>
	                                        </thead>
	                                        <tbody class="user_work_position">
	                                        	@foreach($user_work_list as $item)
	                                        	<tr class="font-helvetica-regular" style="line-height: 40px;">
                                                    <td>{{ $item->userPosition->name}}</td>
                                                    <td>{{ $item->salary }} ₾</td>
                                                    <td>{{ $item->userBranch->name }} / {{ $item->userBranchDepartament->name }}</td>
                                                    <td>
									                    <span class="font-helvetica-regular" onclick="DeleteWorkPosition(this, {{ $item->id }})" style="cursor: pointer;">პოზიცის წაშლა</span>
									                </td>
                                                </tr>
	                                        	@endforeach
	                                        </tbody>
	                                    </table>
	                                    <div class="row mt-4">
	                                    	<div class="col-12">
		                                    	<h5 class="card-title font-neue">აღწერა დამატება</h5>
	                                    	</div>
	                                    	<div class="col-lg-4 mt-2">
	                                    		<div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_position">პოზიცია</label>
		                                    		<select class="form-control" id="user_position">
		                                    			<option value="0"></option>
											      		@foreach($work_position_list as $position_item)
											      		<option value="{{ $position_item->id }}">{{ $position_item->name }}</option>
											      		@endforeach
											      	</select>
										      	</div>
	                                    	</div>
	                                    	<div class="col-lg-4 mt-2">
	                                    		<div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_position_branch">ფილიალი</label>
		                                    		<select class="form-control" id="user_position_branch" onchange="GetDepartamentList()">
		                                    			<option value="0"></option>
											      		@foreach($branch_list as $branch_item)
											      		<option value="{{ $branch_item->id }}">{{ $branch_item->name }}</option>
											      		@endforeach
											      	</select>
										      	</div>
	                                    	</div>
	                                    	<div class="col-lg-4 mt-2">
	                                    		<div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_position_departament">განყოფილება</label>
		                                    		<select class="form-control" id="user_position_departament" disabled>
		                                    			<option value="0">გთხოვთ აირჩიოთ ფილიალი</option>
											      	</select>
										      	</div>
	                                    	</div>
	                                    	<div class="col-lg-4 mt-2">
	                                    		<div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_position_contract_type">ხელშეკრულების ტიპი</label>
		                                    		<select class="form-control" id="user_position_contract_type">
		                                    			<option value="0"></option>
		                                    			@foreach($contract_type as $type_item)
		                                    			<option value="{{ $type_item->id }}">{{ $type_item->name }}</option>
														@endforeach
											      	</select>
										      	</div>
	                                    	</div>
	                                    	<div class="col-lg-4 mt-2">
	                                    		<div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_position_salary_type">ხელფასის ტიპი</label>
		                                    		<select class="form-control" id="user_position_salary_type">
		                                    			<option value="0"></option>
		                                    			<option value="1">ფიქსირებული</option>
		                                    			<option value="2">დღიური</option>
		                                    			<option value="3">ფიქსირებული + დღიური</option>
											      	</select>
										      	</div>
	                                    	</div>
	                                    	<div class="col-lg-4 mt-2">
	                                    		<div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_salary">ხელფასი</label>
						                            <input type="number" class="form-control error-input" id="user_salary">
										      	</div>
	                                    	</div>
	                                    	<div class="col-3 mt-2">
	                                    		<button type="button" class="btn btn-success" onclick="WorkPositionAdd()">
	                                    			<em class="icon ni ni-plus-c"></em>
	                                    		</button>
	                                    	</div>
	                                    </div>
								    </div>
								    <div class="tab-pane p-0 m-3" id="tabItem3">
								    	<table class="table table-ulogs">
	                                        <thead class="thead-light">
	                                            <tr>
	                                                <th class="tb-col-time font-neue px-2"><span class="overline-title">ვინააობა</span></th>
	                                                <th class="tb-col-time font-neue"><span class="overline-title">ტელეფონის ნომერი</span></th>
	                                                <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
	                                            </tr>
	                                        </thead>
	                                        <tbody class="user_contact_list">
	                                        	@foreach($user_contact as $contact_item)
	                                        	<tr class="font-helvetica-regular">
									                <td class="px-2">{{ json_decode($contact_item->value)->identy }}</td>
									                <td>{{ json_decode($contact_item->value)->phone }}</td>
									                <td>
									                    <span class="font-helvetica-regular" onclick="DeleteContact(this, {{ $contact_item->id }})" style="cursor: pointer;">კონტაქტის წაშლა</span>
									                </td>
									            </tr>
									            @endforeach
	                                        </tbody>
	                                    </table>
                                        <div class="row mt-4">
	                                    	<div class="col-12">
		                                    	<h5 class="card-title font-neue">საკონტაქტო ინფორმაციის დამატება</h5>
	                                    	</div>
	                                    	<div class="col-lg-6 mt-2">
	                                    		<div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_contact_identy">ვინაობა</label>
						                            <input type="text" class="form-control error-input" id="user_contact_identy">
										      	</div>
	                                    	</div>
	                                    	<div class="col-lg-6 mt-2">
	                                    		<div class="form-group">
						                            <label class="form-label font-helvetica-regular" for="user_contact_phone">ტელეფონის ნომერი</label>
						                            <input type="text" class="form-control error-input" id="user_contact_phone">
										      	</div>
	                                    	</div>
	                                    	<div class="col-3 mt-2">
	                                    		<button type="button" class="btn btn-success" onclick="ContactAdd()">
	                                    			<em class="icon ni ni-plus-c"></em>
	                                    		</button>
	                                    	</div>
	                                    </div>
								    </div>
		                            <button type="button" onclick="UserSubmit()" class="btn btn-lg btn-primary font-neue ml-3">შენახვა</button>
								</div>
							</form>
				        </div>
				    </div>
				</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/scripts/users_scripts.js') }}"></script>
@endsection