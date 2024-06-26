@extends('layouts.admin')

@section('content')
	<h4 class="mt-2">
		{{ $batch->name }}
		<a class="btn btn-outline-primary m-0 p-0" href="{{ route('admin_batch_edit',$batch->id) }}"> <i class="fas fa-pencil-alt"></i> Edit</a>
		<span class="float-right">{{ $batch->season->name }}</span>
	</h4>
	<div class="row m-0 p-0">
		<div class="col-10 m-0 p-0">
			<b>STUDENTS:</b> 
			<em><b>{{$students['verified']}}</b> verified</em>,
			<em><b>{{$students['notyet']}}</b> not yet verified</em>,
			<em><b>{{$students['total']}}</b> total</em>. 
			<br />
			<b>PAYMENT:</b>
			<em><b> Php {{ number_format($totalpayments->total,2) }}</b> collected </em>, 
			<em><b> {{ $payments['paid'] }}</b> fully paid   </em>, 
			<em><b> {{ $payments['partial'] }}</b> partial   </em>, 
			<em><b> {{ $payments['others'] }}</b> not yet paid  </em>, 
			<br />
			<b>DATE:</b> <em>{{ date('F d,Y',strtotime($batch->date_start)) }} to {{ date('F d,Y',strtotime($batch->date_end)) }}</em>
		</div>
		<div class="col-2 m-0 p-0">
			<a class="btn btn-primary float-right p-0 m-1" href="{{ route('admin_batch_student',$batch->id) }}" ><i class="fa fa-account"></i>MANAGE STUDENTS</a>
			@if(isset($class->vimeo_albumid))
				<div class="float-right" style="width:380px;">
					<a class="btn btn-primary p-0 m-1" target="_blank" href="https://panel.bunny.net/stream/library/manage/79127?collectionId={{$class->vimeo_albumid}}" ><i class="fa fa-account"></i>MANAGE VIDEOS</a>
					<a class="btn btn-outline-primary float-right p-0 m-1"" href="{{ route('admin_batch_videosv2',$class->id) }}"> <i class="fas fa-refresh"></i> UPDATE VIDEOS </a> 
					<a class="btn btn-outline-primary float-right p-0 m-1"" href="{{ route('batch_sync_videos',$class->id) }}"> <i class="fas fa-refresh"></i> SYNC </a> 
				</div>
				<a class="btn p-0 m-1" href="{{ route('admin_batch_videos',$class->id) }}" title="Vimeo Videos (Temporary)" ><i class="fa fa-account"></i>DOWNLOAD</a>
			@endif
		</div>
	</div>
	<div class="blackred" width="100%">
		<nav >
			<div class="nav nav-tabs nav-fill" id="nav-tab" >
				@foreach($courses as $cid => $course)
					<a class="nav-item nav-link {{ ($cid == $courseid)?' show active':'' }}" href="{{ route('admin_batch_view',['batchid'=>$batchid,'courseid'=>$cid]) }}"  >
						{{$course}}
					</a>
				@endforeach
			</div>
		</nav>
		<div class="tab-content py-3 px-3 px-sm-0" >
		
			<div class="tab-pane fade show active" >
				@if(isset($class) && $class)
					<p class="m-0 p-0 text-center" style="border-bottom:solid 5px lightgray">{{$class->course->code}} - {{$class->course->name}}</p>
					<div class="row">
						<div class="col-3">
							<div class="nav flex-column nav-pills p-1" id="v-pills-tab" role="tablist" aria-orientation="vertical">
								@foreach($subjects as $sid => $subject)
									<a class="nav-link {{ ($sid == $subjectid)?' show active':'' }}" href="{{ route('admin_batch_view',['batchid'=>$batchid,'courseid'=>$courseid,'subjectid'=>$sid]) }}">
										{{ $subject }}
									</a>
								@endforeach
							</div>
						</div>
						<div class="col-9">
							<div class="tab-content highlight h-100 p-1">
								<div class="tab-pane fade show active" >
									{{$class->subject->name}}
									<hr />
									<div class="row" >
										<div class="col-5 " align="center">
											@if($class->coach)
												<img style="width:70%;" src="/images/{{ $class->coach->image}}">
												<br />
												<b>
													{{ $class->coach->salutation }}	
													{{ $class->coach->first_name }}	
													{{ $class->coach->middle_name }}	
													{{ $class->coach->last_name }}	
												</b>
												<br />
												<em>{{ $class->coach->title }}</em>	
												<br />
												{!! $class->coach->accomplishments !!}
											@endif
										</div>	
										<div class="col-7">
											<form method="POST" id="contentForm" action="{{ route('admin_batch_save_class') }}" >
												@csrf
												<div class="row align-items-stretch mb-5">
													<div class="col-md-12">
														<div class="form-group mb-2 md-0">
															<div class="form-group form-group-textarea mb-md-0">	
																<select name="coach_id" name="coach_id" class="form-control" name="manual" >
																	@foreach($coaches as $coach)
																		<option value="{{$coach->id}}" {{ ($coach->id == $class->coach_id)?'selected':''}} >
																			{{ $coach->salutation }}	
																			{{ $coach->first_name }}	
																			{{ $coach->middle_name }}	
																			{{ $coach->last_name }}	
																		</option>
																	@endforeach
																</select>
																@error('date_end')
																	<span class="invalid-feedback" role="alert">
																		<strong>{{ $message }}</strong>
																	</span>
																@enderror
															</div>
														</div>
														<div class="form-group-row row">
															<div class="form-group col-6">
																<input id="id" type="hidden" name="id" value="{{ $class->id }}" required >
																<input placeholder="Start Date*" id="date_start" type="date" class="form-control @error('date_start') is-invalid @enderror" name="date_start" value="{{ ($class->date_start)?date('Y-m-d', strtotime($class->date_start)):'' }}" required  >
																@error('date_start')
																	<span class="invalid-feedback" role="alert">
																		<strong>{{ $message }}</strong>
																	</span>
																@enderror
															</div>
															<div class="form-group col-6">
																<input placeholder="End Date*" id="date_end" type="date" class="form-control @error('date_end') is-invalid @enderror" name="date_end" value="{{ ($class->date_end)?date('Y-m-d', strtotime($class->date_end)):'' }}" required >
																@error('date_end')
																	<span class="invalid-feedback" role="alert">
																		<strong>{{ $message }}</strong>
																	</span>
																@enderror
															</div>
														</div>
														<div class="form-group mb-md-0">
															<div class="form-group form-group-textarea mb-md-0">
																<textarea id="remarks" name="remarks"  >{{ $class->remarks }}</textarea>
															</div>
															@error('remarks')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
														<hr />
														<button class="btn btn-primary btn-xl text-uppercase" id="sendMessageButton" type="submit">SUBMIT</button>
													</div>
												</div>
											</form>
										</div>
									</div>
									<div style="border:solid 2px white;border-radius:5px;">
										<div class="row" >
											<div class="col-12">
												<p class="p-0 m-0" style="border-bottom:solid 3px lightgray;" >
													<b><em> PDF ATTACHMENTS </em></b>
												</p>
											</div>
											<div class="col-5">
												<ul class="list-group list-group-flush">
													@foreach($class->attachments as $attachment)
														<li class="list-group-item" style="background: none;">
															{{$attachment->name}}
															<a class="btn btn-danger float-right p-0 py-1 m-0" onclick="event.preventDefault(); if(confirm('Are you sure? \n Removing attachment will also delete the file at serve.')){document.getElementById('remove-batch{{$attachment->id}}-form').submit();}">
																<i class="fa fa-eraser"></i>
																{{ __('remove') }}
															</a>
															<form id="remove-batch{{$attachment->id}}-form" action="{{ route('admin_attachm_remove') }}" method="POST" class="d-none">
																@csrf
																<input type="hidden" name="id" value="{{$attachment->id}}" />
															</form>
															<!--<button class="btn btn-primary float-right p-0 py-1 m-0" onclick="readPDF({{ $attachment->token }});" >
																<i class="fa fa-book-open"></i> read
															</button>-->
															<!--
															@if($attachment->type == 1)
																<button class="btn btn-primary float-right p-1 m-0" onclick="playAttachedMov({{ $attachment->id }});" ><i class="fa fa-play"></i> PLAY</button>
															@elseif($attachment->type == 3)
																<button class="btn btn-primary float-right p-1 m-0" onclick="readPDF({{ $attachment->filename }});" ><i class="fa fa-book-open"></i> READ</button>
															@endif
															-->
														</li>
													@endforeach
												</ul>
											</div>	
											<div class="col-7">
												<div class="w-100 text-right">
													<div style="display:none;">
														<input type="file"  id="uploadVideoFile" accept="video/*" />
													</div>
													<button type="button" id="openVideoButton" style="display:none;" class="btn btn-outline-primary float-right m-1 p-0 px-1">OPEN VIDEO FILE</button>
												</div>
												<div class="w-100 text-right">
													<div style="display:none;">
														<input type="file"  id="uploadPDFFile" accept="application/pdf" />
													</div>
													<button type="button" id="openPDFButton" class="btn btn-outline-primary float-right m-1 p-0 px-1">UPLOAD PDF FILE</button>
												</div>
												<div id="pdfWrapper">
													<iframe id="pdfFrame" style="width: 100%;" frameborder="0" allowfullscreen ></iframe>
												</div>
												<div id="videoSourceWrapper">
													<video id="videoPlayer" style="width: 100%;" controls>
														<source id="videoSource"/>
													</video>
												</div>
												<div class="w-100 row" style="display:none;" >
													<input type="text" class=" col-9 form-control" placeholder="NAME*" id="uploadFileName" />
													<button type="button" id="uploadVideoButton" class="btn btn-outline-success col-3 p-0">START UPLOAD</button>
												</div>
												
												<div class="card" style="display:none;z-index:1101 !important;" id="uploadDetails">
													<div class="card-header">
														<b>UPLOADING FILE</b>
													</div>
													<div class="card-body">
														<p class="w-100 p-0 m-0">This may take some time. Please do not interrupt the upload. </p>
														<div id="uploadVideoProgressBar" style="height: 15px; width: 1%; background: #2781e9; margin-top: -5px;"></div> 
													</div>
												</div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
@endsection
@once
	@push('scripts')
		<script>
			var atype = 1;
			$(document).ready(function(){
				$("#videoSourceWrapper").hide();
				$("#pdfWrapper").hide();
				jQuery("#openVideoButton").click(function(){
					jQuery("#uploadVideoFile").trigger("click");
					
				});
				jQuery("#openPDFButton").click(function(){
					jQuery("#uploadPDFFile").trigger("click");
				});

				jQuery("#uploadPDFButton").click(function(){
					if(jQuery('#uploadFileName').val()){
						var fileInput = document.getElementById("uploadVideoFile");
						if ('files' in fileInput) {
							if (fileInput.files.length === 0) {
								alert("Select a file to upload");
							} else {
								UploadVideo(fileInput.files[0]);
								jQuery("#uploadVideoButton").parent().hide();
							}
						} else {
							console.log('No found "files" property');
						}
					}else{
						alert("Please enter name.");
						jQuery('#uploadFileName').focus();
					}
					
				});

				jQuery('#uploadPDFFile').on('change',
					function() {
						var fileInput = document.getElementById("uploadPDFFile");
						console.log('Trying to upload the video file: %O', fileInput);

						if ('files' in fileInput) {
							if (fileInput.files.length === 0) {
								alert("Select a file to upload");
							} else {
								if(fileInput.files[0].type == "application/pdf" ){
									jQuery("#pdfWrapper").show();
									jQuery("#videoSourceWrapper").hide();
									jQuery('#pdfFrame').attr('src',URL.createObjectURL(this.files[0]));
									jQuery("#uploadVideoButton").parent().show();
									atype = 2;
								}else{
									alert("Please select pdf file.");
									document.getElementById("uploadVideoFile").value = "";
								}
							}
						} else {
							console.log('No found "files" property');
						}
					}
				);
				
				jQuery('#uploadVideoFile').on('change',
					function() {
						var fileInput = document.getElementById("uploadVideoFile");
						console.log('Trying to upload the video file: %O', fileInput);

						if ('files' in fileInput) {
							if (fileInput.files.length === 0) {
								alert("Select a file to upload");
							} else {
								if(fileInput.files[0].type.substring(0,5) == "video" ){
									$("#pdfWrapper").hide();
									$("#videoSourceWrapper").show();
									var $source = $('#videoSource');
									$source[0].src = URL.createObjectURL(this.files[0]);
									$source.parent()[0].load();
									jQuery("#uploadVideoButton").parent().show();
									atype = 1;
								}else{
									alert("Please select video file.");
									document.getElementById("uploadVideoFile").value = "";
								}
							}
						} else {
							console.log('No found "files" property');
						}
					}
				);
				
				jQuery("#uploadVideoButton").click(function(){
					if(jQuery('#uploadFileName').val()){
						if(atype == 1)
							var fileInput = document.getElementById("uploadVideoFile");
						if(atype == 2)
							var fileInput = document.getElementById("uploadPDFFile");
						if ('files' in fileInput) {
							if (fileInput.files.length === 0) {
								alert("Select a file to upload");
							} else {
								UploadVideo(fileInput.files[0]);
								jQuery("#uploadVideoButton").parent().hide();
								
							}
						} else {
							console.log('No found "files" property');
						}
					}else{
						alert("Please enter name.");
						jQuery('#uploadFileName').focus();
					}
					
				});
				
				ClassicEditor
					.create( document.querySelector( '#remarks' ), {
						// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
					} )
					.then( editor => {
						editor.ui.view.editable.element.style.height = '300px';
						window.editor = editor;
					} )
					.catch( err => {
						console.error( err.stack );
					} );
			});


			
			
			function playAttachedMov(id){
				
				$("#pdfWrapper").hide();
				$("#videoSourceWrapper").show();

				var video = document.getElementById('videoPlayer');
				
				video.setAttribute('src', "{{ route('admin_stream_mov','')}}/"+id);
				video.load();
				video.play();

				
			}

			function UploadVideo(file) {

				var loaded = 0;
				var chunkSize = 52428800;//26214400;//5242880;
				var total = file.size;
				var reader = new FileReader();
				var slice = file.slice(0, chunkSize);
				var attachmentid = null,xcatt = null;
				var percentLoaded = 0;
				reader.readAsBinaryString(slice); 
				console.log('Started uploading file "' + file.name + '"');
				jQuery('#uploadDetails').show();
				jQuery.blockUI({message:'<img src="/assets/img/spinner.gif">  Please wait ... '});
				reader.onload = function (e) {
					data = {
					//	"_token":"{{ csrf_token() }}",
					//	slice : arrayBufferToBase64String(e.target.result),
					//	"dataType": "json",
					//	"start":loaded, 
					//	"end":loaded + chunkSize,
						"fileid":attachmentid,
					//	"proc":percentLoaded
					};

					if(xcatt == null){
						data = {};
						data.class_id = "{{ ($class)?$class->id:''}}";
						data.filename = file.name;
						data.name = jQuery('#uploadFileName').val();
						data.type = atype;
						xcatt = btoa(JSON.stringify(data));
						console.log('xcat');
					}
					

					jQuery.ajax({
						url: "/admin/attachment/save_chunk",
						type: "POST",
						data: slice,
						beforeSend: function(xhr){
							xhr.setRequestHeader('X-CAtt',xcatt);
							xhr.setRequestHeader('X-CAttS',loaded);
						},
						processData: false,
						//contentType: false,
						error: (function (errorData) {
							console.log(errorData);
							jQuery.unblockUI();
							alert("Video Upload Failed");
						})
					}).done(function (data) { 
						if(data.result != undefined){
							if(attachmentid == null){
								attachmentid = data.attachmentid;
								data = {};
								data.attachmentid = attachmentid;
								xcatt = btoa(JSON.stringify(data))
								console.log('attachmentid');
							}
							loaded += chunkSize;
							percentLoaded = Math.min((loaded / total) * 100, 100);
							console.log('Uploaded ' + Math.floor(percentLoaded) + '% of file "' + file.name + '"');
							$('#uploadVideoProgressBar').width(percentLoaded + "%");

							if (loaded <= total) {
								slice = file.slice(loaded, loaded + chunkSize);
								isFirstChunk = false;
								reader.readAsArrayBuffer(slice);
							} else { 
								loaded = total;
								console.log('File "' + file.name + '" uploaded successfully!');
								$('#uploadDetails').hide();
								$("#videoSourceWrapper").hide();
								$("#pdfWrapper").hide();
								jQuery.unblockUI();
							}
						}
					});
				}
				
			}

			

			
		</script>

		
	@endpush
@endonce