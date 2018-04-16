@extends('master')
@section('content')
<link href="{{ asset('fiture-style/select2/select2.min.css') }}" rel="stylesheet">
<div class="container-fluid">
	<div class="animate fadeIn">
		<div class="row">
			<div class="col-lg-2"></div>
			<div class="col-lg-8">
				<p>
				<button type="button" class="btn btn-primary" onclick="window.history.back()">
					<i class="fa fa-backward"></i>&nbsp; Back to List
				</button>
				</p>
				<!--start card -->
				<div class="card">
					<div class="card-header">
						<i class="fa fa-align-justify"></i> Slider
						<small></small>
					</div>
					<div class="card-body">
						
						<div class="tab-content" id="myTab1Content">
						<!-- TAB CONTENT -->
							
							<div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
								<div class="row">
									<div class="col-md-12">
										<form id="jxForm1" onsubmit="return false;" enctype="multipart/form-data">
											{{ csrf_field() }}
											<input type="hidden" class="id" name="id">
											<div class="row">
												<div class="col-md-6">
												<!-- <div class="form-group">
														<label class="col-form-label" for="role">*product</label>
														<select id="product" class="form-control" style="width: 100% !important;" name="role"
															aria-describedby="role-error">
															<option value=""></option>
															@foreach($products as $product)
															<option value="{{$role->id}}"
																data-description="{{$product->description}}">{{$product->name}}</option>
															@endforeach
														</select>
														<em id="role-error" class="error invalid-feedback">Please select</em>
													</div> -->
													<div class="form-group">
														<label class="col-form-label" for="name">*Name of Slider</label>
														<input type="text" class="form-control" id="name" name="name" placeholder="Name"
															aria-describedby="name-error">
														<em id="name-error" class="error invalid-feedback">Please enter a name of slider </em>
													</div>
													<div class="text-center">
														<img class="rounded picturePrev" src="{{ asset('img/fiture-logo.png') }}" 
															style="width: 150px; height: 150px;">
													</div>
													<div class="form-group">
														<label class="col-form-label" for="name">Picture (150x150)</label>
														<input type="file" class="form-control" id="picture" name="picture" placeholder="picture">
													</div>
												</div>
												</div>
											<hr>
											<p>
												<button type="button" class="btn btn-success" onclick="save('#jxForm1','','exit')"> &nbsp; Save</button>
												
												<button type="button" class="btn btn-secondary" onclick="window.history.back()">
													<i class="fa fa-times-rectangle"></i>&nbsp; Cancel
												</button>
											</p>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/select2/select2.min.js') }}"></script>
<script>
	var progressStat = false;
	
	$('#role').select2({theme:"bootstrap", placeholder:'Please select'});
	$('#role').on('change', function(){
		$(this).addClass('is-valid').removeClass('is-invalid');
	});
	
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e){ $('.picturePrev').attr('src', e.target.result); }
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#picture").change(function (){ readURL(this); });
	
	$("#jxForm1").validate({
		rules:{
			name:{required:true,minlength:2},
		},
		messages:{
			name:{
				required:'Please enter a name user',
				minlength:'Name must consist of at least 2 characters'
			}
		},
		errorElement:'em',
		errorPlacement:function(error,element){
			error.addClass('invalid-feedback');
		},
		highlight:function(element,errorClass,validClass){
			$(element).addClass('is-invalid').removeClass('is-valid');
		},
		unhighlight:function(element,errorClass,validClass){
			$(element).addClass('is-valid').removeClass('is-invalid');
		}
	});
	
	function save(formAct1,formAct2,action){
		var sendForm = ( formAct1 != '' ? formAct1 : formAct2 );
		
		//check form Tab 1 GENERAL
		if(formAct1 != ''){
			$('#general-tab').click();
			setTimeout(function(){
				if($("#jxForm1").valid()){
					postData(formAct1,formAct2,action,sendForm);
				}
			}, 400);
		}
		
		//check form Tab 2 Permisssion
		if(formAct2 != '' && formAct1 == ''){
			$('#rp-tab').click();
			if($('.id').val() == ''){
				$('#general-tab').click();
			}else{
				postData(formAct1,formAct2,action,sendForm);
			}
		}	
	}
	
	function postData(formAct1,formAct2,action,sendForm){
		if(!progressStat){
			$('.showProgress').click();
			progressStat = true;
		}
		
		$.ajax({
			url : "{{ route('slider.index') }}",
			type: 'POST',
			processData: false,
        	contentType: false,
			data : new FormData($(sendForm)[0]),
			success : function(response){
				if($('.id').val() == ''){
					$('.id').val(response);
				}
				
				if(formAct1 != '' && formAct2 != ''){
					save('',formAct2,action);
				}else{
					setTimeout(function(){
						progressStat = false;
						$('#progressModal').modal('toggle');
						act(action);
					}, {{env('SET_TIMEOUT', '500')}});
				}
			},
			error : function(e){
				setTimeout(function(){
					progressStat = false;
					$('#progressModal').modal('toggle'); 
					alert(' Error : ' + e.statusText);
				}, {{env('SET_TIMEOUT', '500')}});
			}
		});
	}
	
	function act(action){
		switch(action) {
		    case 'continue':
		        toastr.success('Successfully saved..', '');
		        break;
		    case 'new':
		        window.open("{{ route('slider.create') }}", "_self");
		        break;
		    case 'exit':
		        window.open("{{ route('slider.index') }}", "_self");
		}
	}
	
</script>
@endsection