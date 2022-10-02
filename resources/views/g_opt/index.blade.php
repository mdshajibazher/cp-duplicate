@extends('layouts.adminlayout')
@section('title','Edit General Option')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center">Edit General Options</h5>
                </div>
                <!-- card body start -->
                <div class="card-body p-5">
                    <form action="{{route('generaloption.update',$g_opt->id)}}" method="POST"
                          enctype="multipart/form-data" id="general_option_form">
                        @csrf
                        @method('PUT')
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">

                            <div class="w-100 text-center mb-3"><h4>Inventory Section</h4></div>
                            <div class="d-flex justify-content-between mb-3">
                                <div>Differnet Inventory Invoice Heading</div>
                                <div>
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="inv_diff_invoice_heading"
                                               class="onoffswitch-checkbox" id="inv_diff_invoice_heading" value="1"
                                               @if($g_opt_value['inv_diff_invoice_heading'] == 1) checked @endif>
                                        <label class="onoffswitch-label" for="inv_diff_invoice_heading">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="diff_inv_input">
                                <div>Invoice Heaing</div>
                                <div><input type="text" class="form-control" id="inv_invoice_heading"
                                            name="inv_invoice_heading"
                                            value="{{$g_opt_value['inv_invoice_heading']}}"></div>
                            </div>
                            <div class="diff_inv_input">
                                <div>Invoice Email</div>
                                <div><input type="email" class="form-control" id="inv_invoice_email"
                                            name="inv_invoice_email" value="{{$g_opt_value['inv_invoice_email']}}">
                                </div>
                            </div>
                            <div class="diff_inv_input">
                                <div>Invoice Phone</div>
                                <div><input type="text" class="form-control" id="inv_invoice_phone"
                                            name="inv_invoice_phone" value="{{$g_opt_value['inv_invoice_phone']}}">
                                </div>
                            </div>

                            <div class="diff_inv_input">
                                <div>Invoice Address</div>
                                <div><textarea rows="7" class="form-control" id="inv_invoice_address"
                                               name="inv_invoice_address">{{$g_opt_value['inv_invoice_address']}}</textarea>
                                </div>
                            </div>
                            <div class="diff_inv_input">
                                <div>Invoice Logo</div>
                                <div><input type="file" class="form-control" name="inv_invoice_logo">
                                    <img style="width: 200px"
                                         src="{{asset('uploads/logo/invoicelogo/'.$g_opt_value['inv_invoice_logo'])}}"
                                         alt="">
                                </div>

                            </div>


                            <div class="d-flex justify-content-between mb-3">
                                <div>Auto Signature On Inventory Invoices</div>
                                <div>
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="auto_signature_inv"
                                               class="onoffswitch-checkbox" id="auto_signature_inv" value="1"
                                               @if($g_opt_value['auto_signature_inv'] == 1) checked @endif>
                                        <label class="onoffswitch-label" for="auto_signature_inv">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 text-center mb-3"><h4>Ware House Configuration</h4></div>
                            <div class="d-flex justify-content-between mb-3">
                                <div>Default Warehouse</div>
                                <div>
                                    <select name="warehouse_id" id="warehouse_id" class="form-control">
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{$warehouse->id}}"  @if($g_opt_value['warehouse_id'] == $warehouse->id) selected @endif>{{$warehouse->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="w-100 text-center mb-3"><h4>General SMS Configuration</h4></div>
                            <div class="d-flex justify-content-between mb-3">
                                <div>Is customer Sales Invoice SMS Notification Includes Product Information</div>
                                <div><label class="switch">
                                        <input type="checkbox" name="cust_sales_invoice_includes_product"
                                               id="cust_sales_invoice_includes_product" value="1"
                                               @if($g_opt_value['cust_sales_invoice_includes_product'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Is customer return Invoice SMS Notification Includes Product Information</div>
                                <div><label class="switch">
                                        <input type="checkbox" name="cust_return_invoice_includes_product"
                                               id="cust_return_invoice_includes_product" value="1"
                                               @if($g_opt_value['cust_return_invoice_includes_product'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Maximum Product Information Charecter Allowed in SMS</div>
                                <div><input type="number" class="form-control" name="max_product_character_allowed"
                                            value="{{$g_opt_value['max_product_character_allowed']}}"></div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <div>Old entry maximum delay in days for allowing SMS</div>
                                <div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <button type="button" onclick="decrementDaysLimit()" class="btn btn-danger">-
                                        </button>
                                        <input type="number" class="form-control" style="width: 80px"
                                               name="sms_delay_in_days" id="sms_delay_in_days"
                                               value="{{$g_opt_value['sms_delay_in_days']}}" readonly>
                                        <button type="button" onclick="incrementDaysLimit()" class="btn btn-danger">+
                                        </button>
                                    </div>

                                </div>
                            </div>


                            <div class="w-100 text-center mb-3"><h4>Admin SMS Notification</h4></div>
                            <div class="d-flex justify-content-between mb-3">
                                <div>Sales Invoice Created <span class="badge badge-warning">Admin SMS</span></div>
                                <div>
                                    <label class="switch">
                                        <input type="checkbox" name="admin_sales_invoice_created_notify"
                                               id="admin_sales_invoice_created_notify" value="1"
                                               @if($g_opt_value['admin_sales_invoice_created_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="admin_sales_invoice_created_wrapper subsection_wrapper mb-3"
                                 @if($g_opt_value['admin_sales_invoice_created_notify'] == 1)   style="display: block"
                                 @else style="display: none" @endif >
                                <div class="mb-3">Select Some Admin for <b>Sales Invoice Created</b> Notification
                                </div>
                                <div>
                                    <select class="w-100" name="admin_list_sales_invoice_created_notify[]"
                                            id="admin_list_sales_invoice_created_notify" multiple>
                                        @foreach($admins as $admin)
                                            <option value="{{$admin->id}}"
                                                    @if(count($g_opt_value['admin_list_sales_invoice_created_notify']) > 0)
                                                    @foreach($g_opt_value['admin_list_sales_invoice_created_notify'] as $admin_id)
                                                    @if((int) $admin_id === (int) $admin->id)    selected @endif
                                                @endforeach
                                                @endif >{{$admin->name .' - ('.$admin->phone.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Sales Invoice Edited <span class="badge badge-warning">Admin SMS</span></div>
                                <div>
                                    <!-- Rounded switch -->
                                    <label class="switch">
                                        <input type="checkbox" name="admin_sales_invoice_edited_notify"
                                               id="admin_sales_invoice_edited_notify" value="1"
                                               @if($g_opt_value['admin_sales_invoice_edited_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>


                            <div class="admin_sales_invoice_edited_wrapper subsection_wrapper mb-3"
                                 @if($g_opt_value['admin_sales_invoice_edited_notify'] == 1)   style="display: block"
                                 @else style="display: none" @endif >
                                <div class="mb-3">Select Some Admin for <b>Sales Invoice Edited</b> Notification</div>
                                <div>
                                    <select class="w-100" name="admin_list_sales_invoice_edited_notify[]"
                                            id="admin_list_sales_invoice_edited_notify" multiple>
                                        @foreach($admins as $admin)
                                            <option value="{{$admin->id}}"
                                                    @if(count($g_opt_value['admin_list_sales_invoice_edited_notify']) > 0)
                                                    @foreach($g_opt_value['admin_list_sales_invoice_edited_notify'] as $admin_id)
                                                    @if((int) $admin_id === (int) $admin->id)    selected @endif
                                                @endforeach
                                                @endif>{{$admin->name .' - ('.$admin->phone.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <div>Sales Invoice Canceled <span class="badge badge-warning">Admin SMS</span></div>
                                <div>
                                    <!-- Rounded switch -->
                                    <label class="switch">
                                        <input type="checkbox" name="admin_sales_invoice_canceled_notify"
                                               id="admin_sales_invoice_canceled_notify" value="1"
                                               @if($g_opt_value['admin_sales_invoice_canceled_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="admin_sales_invoice_canceled_wrapper subsection_wrapper mb-3"
                                 @if($g_opt_value['admin_sales_invoice_canceled_notify'] == 1)   style="display: block"
                                 @else style="display: none" @endif>
                                <div class="mb-3">Select Some Admin for <b>Sales Invoice Calceled</b> Notification
                                </div>
                                <div>
                                    <select class="w-100" name="admin_list_sales_invoice_canceled_notify[]"
                                            id="admin_list_sales_invoice_canceled_notify" multiple>
                                        @foreach($admins as $admin)
                                            <option value="{{$admin->id}}"
                                                    @if(count($g_opt_value['admin_list_sales_invoice_canceled_notify']) > 0)
                                                    @foreach($g_opt_value['admin_list_sales_invoice_canceled_notify'] as $admin_id)
                                                    @if((int) $admin_id === (int) $admin->id)    selected @endif
                                                @endforeach
                                                @endif >{{$admin->name .' - ('.$admin->phone.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Return Invoice Created <span class="badge badge-warning">Admin SMS</span></div>
                                <div>
                                    <!-- Rounded switch -->
                                    <label class="switch">
                                        <input type="checkbox" name="admin_return_invoice_created_notify"
                                               id="admin_return_invoice_created_notify" value="1"
                                               @if($g_opt_value['admin_return_invoice_created_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>


                            <div class="admin_return_invoice_created_wrapper subsection_wrapper mb-3"
                                 @if($g_opt_value['admin_return_invoice_created_notify'] == 1)   style="display: block"
                                 @else style="display: none" @endif>
                                <div class="mb-3">Select Some Admin for <b>Return Invoice Created</b> Notification
                                </div>
                                <div>
                                    <select class="w-100" name="admin_list_return_invoice_created_notify[]"
                                            id="admin_list_return_invoice_created_notify" multiple>
                                        @foreach($admins as $admin)
                                            <option
                                                value="{{$admin->id}}"
                                                @if(count($g_opt_value['admin_list_return_invoice_created_notify']) > 0)
                                                @foreach($g_opt_value['admin_list_return_invoice_created_notify'] as $admin_id)
                                                @if((int) $admin_id === (int) $admin->id)    selected @endif
                                                @endforeach
                                                @endif
                                            >{{$admin->name .' - ('.$admin->phone.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Return Invoice Edited <span class="badge badge-warning">Admin SMS</span></div>
                                <div>
                                    <!-- Rounded switch -->
                                    <label class="switch">
                                        <input type="checkbox" name="admin_return_invoice_edited_notify"
                                               id="admin_return_invoice_edited_notify" value="1"
                                               @if($g_opt_value['admin_return_invoice_edited_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="admin_return_invoice_edited_wrapper subsection_wrapper mb-3"
                                 @if($g_opt_value['admin_return_invoice_edited_notify'] == 1)   style="display: block"
                                 @else style="display: none" @endif>
                                <div class="mb-3">Select Some Admin for <b>Return Invoice Edited</b> Notification
                                </div>
                                <div>
                                    <select class="w-100" name="admin_list_return_invoice_edited_notify[]"
                                            id="admin_list_return_invoice_edited_notify" multiple>
                                        @foreach($admins as $admin)
                                            <option value="{{$admin->id}}"
                                                    @if(count($g_opt_value['admin_list_return_invoice_edited_notify']) > 0)
                                                    @foreach($g_opt_value['admin_list_return_invoice_edited_notify'] as $admin_id)
                                                    @if((int) $admin_id === (int) $admin->id)    selected @endif
                                                @endforeach
                                                @endif
                                            >{{$admin->name .' - ('.$admin->phone.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Return Invoice canceled <span class="badge badge-warning">Admin SMS</span></div>
                                <div>
                                    <!-- Rounded switch -->
                                    <label class="switch">
                                        <input type="checkbox" name="admin_return_invoice_canceled_notify"
                                               id="admin_return_invoice_canceled_notify" value="1"
                                               @if($g_opt_value['admin_return_invoice_canceled_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="admin_return_invoice_canceled_wrapper subsection_wrapper mb-3"
                                 @if($g_opt_value['admin_return_invoice_canceled_notify'] == 1)   style="display: block"
                                 @else style="display: none" @endif>
                                <div class="mb-3">Select Some Admin for <b>Return Invoice Canceled</b> Notification
                                </div>
                                <div>
                                    <select class="w-100" name="admin_list_return_invoice_canceled_notify[]"
                                            id="admin_list_return_invoice_canceled_notify" multiple>
                                        @foreach($admins as $admin)
                                            <option
                                                value="{{$admin->id}}"
                                                @if(count($g_opt_value['admin_list_return_invoice_canceled_notify']) > 0)
                                                @foreach($g_opt_value['admin_list_return_invoice_canceled_notify'] as $admin_id)
                                                @if((int) $admin_id === (int) $admin->id)    selected @endif
                                                @endforeach
                                                @endif
                                            >{{$admin->name .' - ('.$admin->phone.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="d-flex justify-content-between mb-3">
                                <div>Daily Orders Created <span class="badge badge-warning">Admin SMS</span></div>
                                <div>
                                    <!-- Rounded switch -->
                                    <label class="switch">
                                        <input type="checkbox" name="admin_daily_order_created_notify"
                                               id="admin_daily_order_created_notify" value="1"
                                        @if($g_opt_value['admin_daily_order_created_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="admin_daily_order_created_wrapper subsection_wrapper mb-3"
                                 @if($g_opt_value['admin_daily_order_created_notify'] == 1)   style="display: block"
                                 @else style="display: none" @endif >
                                <div class="mb-3">Select Some Admin for <b>Daily Order Created</b> Notification
                                </div>
                                <div>
                                    <select class="w-100" name="admin_list_daily_order_created_notify[]"
                                            id="admin_list_daily_order_created_notify" multiple>
                                        @foreach($admins as $admin)
                                            <option
                                                value="{{$admin->id}}"
                                                @if(count($g_opt_value['admin_list_daily_order_created_notify']) > 0)
                                                @foreach($g_opt_value['admin_list_daily_order_created_notify'] as $admin_id)
                                                @if((int) $admin_id === (int) $admin->id)    selected @endif
                                                @endforeach
                                                @endif
                                            >{{$admin->name .' - ('.$admin->phone.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="d-flex justify-content-between mb-3">
                                <div>Daily Orders Edited <span class="badge badge-warning">Admin SMS</span></div>
                                <div>
                                    <!-- Rounded switch -->
                                    <label class="switch">
                                        <input type="checkbox" name="admin_daily_order_edited_notify"
                                               id="admin_daily_order_edited_notify" value="1"
                                        @if($g_opt_value['admin_daily_order_edited_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="admin_daily_order_edited_wrapper subsection_wrapper mb-3"
                                 @if($g_opt_value['admin_daily_order_edited_notify'] == 1)   style="display: block"
                                 @else style="display: none" @endif>
                                <div class="mb-3">Select Some Admin for <b>Daily Order Edited</b> Notification
                                </div>
                                <div>
                                    <select class="w-100" name="admin_list_daily_order_edited_notify[]"
                                            id="admin_list_daily_order_edited_notify" multiple>
                                        @foreach($admins as $admin)
                                            <option
                                                value="{{$admin->id}}"
                                                @if(count($g_opt_value['admin_list_daily_order_edited_notify']) > 0)
                                                @foreach($g_opt_value['admin_list_daily_order_edited_notify'] as $admin_id)
                                                @if((int) $admin_id === (int) $admin->id)    selected @endif
                                                @endforeach
                                                @endif
                                            >{{$admin->name .' - ('.$admin->phone.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Cash Edited <span class="badge badge-warning">Admin SMS</span></div>
                                <div>
                                    <!-- Rounded switch -->
                                    <label class="switch">
                                        <input type="checkbox" name="admin_cash_edited_notify"
                                               id="admin_cash_edited_notify" value="1"
                                               @if($g_opt_value['admin_cash_edited_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="w-100 text-center mb-3"><h4>Admin e-mail Notification</h4></div>
                            <div class="d-flex justify-content-between mb-3">
                                <div>Sales Invoice Created <span class="badge badge-danger">Admin e-mail</span></div>
                                <div>
                                    <label class="switch">
                                        <input type="checkbox" name="admin_email_sales_invoice_created"
                                               id="admin_email_sales_invoice_created" value="1"
                                               @if($g_opt_value['admin_email_sales_invoice_created'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="admin_email_sales_invoice_created_wrapper subsection_wrapper mb-3"
                                 @if($g_opt_value['admin_email_sales_invoice_created'] == 1)   style="display: block"
                                 @else style="display: none" @endif
                            >
                                <div class="mb-3">Select Some Admin for <b>Sales Invoice Created</b> mail Notification
                                </div>
                                <div>
                                    <select class="w-100" name="admin_list_email_sales_invoice_created[]"
                                            id="admin_list_email_sales_invoice_created" multiple>
                                        @foreach($admins as $admin)
                                            <option value="{{$admin->id}}"
                                                    @if(count($g_opt_value['admin_list_email_sales_invoice_created']) > 0)
                                                    @foreach($g_opt_value['admin_list_email_sales_invoice_created'] as $admin_id)
                                                    @if((int) $admin_id === (int) $admin->id)    selected @endif
                                                @endforeach
                                                @endif
                                            >{{$admin->name .' - ('.$admin->email.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <div>Sales Invoice Edited <span class="badge badge-danger">Admin e-mail</span></div>
                                <div>
                                    <label class="switch">
                                        <input type="checkbox" name="admin_email_sales_invoice_edited"
                                               id="admin_email_sales_invoice_edited" value="1"
                                               @if($g_opt_value['admin_email_sales_invoice_edited'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="admin_email_sales_invoice_edited_wrapper subsection_wrapper mb-3"
                                 @if($g_opt_value['admin_email_sales_invoice_edited'] == 1)   style="display: block"
                                 @else style="display: none" @endif
                            >
                                <div class="mb-3">Select Some Admin for <b>Sales Invoice edited</b> mail Notification
                                </div>
                                <div>
                                    <select class="w-100" name="admin_list_email_sales_invoice_edited[]"
                                            id="admin_list_email_sales_invoice_edited" multiple>
                                        @foreach($admins as $admin)
                                            <option value="{{$admin->id}}"
                                                    @if(count($g_opt_value['admin_list_email_sales_invoice_edited']) > 0)
                                                    @foreach($g_opt_value['admin_list_email_sales_invoice_edited'] as $admin_id)
                                                    @if((int) $admin_id === (int) $admin->id)    selected @endif
                                                @endforeach
                                                @endif
                                            >{{$admin->name .' - ('.$admin->email.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Product Return Invoice Created <span class="badge badge-danger">Admin e-mail</span>
                                </div>
                                <div>
                                    <label class="switch">
                                        <input type="checkbox" name="admin_email_return_invoice_created"
                                               id="admin_email_return_invoice_created" value="1"
                                               @if($g_opt_value['admin_email_return_invoice_created'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="admin_email_return_invoice_created_wrapper subsection_wrapper mb-3"
                                 @if($g_opt_value['admin_email_return_invoice_created'] == 1)   style="display: block"
                                 @else style="display: none" @endif
                            >
                                <div class="mb-3">Select Some Admin for <b>Product Return Invoice Created </b> mail
                                    Notification
                                </div>
                                <div>
                                    <select class="w-100" name="admin_list_email_return_invoice_created[]"
                                            id="admin_list_email_return_invoice_created" multiple>
                                        @foreach($admins as $admin)
                                            <option value="{{$admin->id}}"
                                                    @if(count($g_opt_value['admin_list_email_return_invoice_created']) > 0)
                                                    @foreach($g_opt_value['admin_list_email_return_invoice_created'] as $admin_id)
                                                    @if((int) $admin_id === (int) $admin->id)    selected @endif
                                                @endforeach
                                                @endif
                                            >{{$admin->name .' - ('.$admin->email.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Product Return Invoice Edited <span class="badge badge-danger">Admin e-mail</span>
                                </div>
                                <div>
                                    <label class="switch">
                                        <input type="checkbox" name="admin_email_return_invoice_edited"
                                               id="admin_email_return_invoice_edited" value="1"
                                               @if($g_opt_value['admin_email_return_invoice_edited'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="admin_email_return_invoice_edited_wrapper subsection_wrapper mb-3"
                                 @if($g_opt_value['admin_email_return_invoice_edited'] == 1)   style="display: block"
                                 @else style="display: none" @endif
                            >
                                <div class="mb-3">Select Some Admin for <b>Product Return Invoice Edited</b> mail
                                    Notification
                                </div>
                                <div>
                                    <select class="w-100" name="admin_list_email_return_invoice_edited[]"
                                            id="admin_list_email_return_invoice_edited" multiple>
                                        @foreach($admins as $admin)
                                            <option value="{{$admin->id}}"
                                                    @if(count($g_opt_value['admin_list_email_return_invoice_edited']) > 0)
                                                    @foreach($g_opt_value['admin_list_email_return_invoice_edited'] as $admin_id)
                                                    @if((int) $admin_id === (int) $admin->id)    selected @endif
                                                @endforeach
                                                @endif
                                            >{{$admin->name .' - ('.$admin->email.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="w-100 text-center mb-3"><h4>Customer SMS Notification</h4></div>
                            <div class="d-flex justify-content-between mb-3">
                                <div>Sales Invoice Created <span class="badge badge-info">customer SMS</span></div>
                                <div>
                                    <!-- Rounded switch -->
                                    <label class="switch">
                                        <input type="checkbox" name="customer_sales_invoice_created_notify"
                                               id="customer_sales_invoice_created_notify" value="1"
                                               @if($g_opt_value['customer_sales_invoice_created_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Sales Invoice Edited <span class="badge badge-info">customer SMS</span></div>
                                <div>
                                    <!-- Rounded switch -->
                                    <label class="switch">
                                        <input type="checkbox" name="customer_sales_invoice_edited_notify"
                                               id="customer_sales_invoice_edited_notify" value="1"
                                               @if($g_opt_value['customer_sales_invoice_edited_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Sales Invoice Canceled <span class="badge badge-info">customer SMS</span></div>
                                <div>
                                    <label class="switch">
                                        <input type="checkbox" name="customer_sales_invoice_canceled_notify"
                                               id="customer_sales_invoice_canceled_notify" value="1"
                                               @if($g_opt_value['customer_sales_invoice_canceled_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Sales Invoice Delivered <span class="badge badge-info">customer SMS</span></div>
                                <div>
                                    <label class="switch">
                                        <input type="checkbox" name="customer_sales_invoice_delivered_notify"
                                               id="customer_sales_invoice_delivered_notify" value="1"
                                               @if($g_opt_value['customer_sales_invoice_delivered_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Return Invoice Created <span class="badge badge-info">customer SMS</span></div>
                                <div>
                                    <label class="switch">
                                        <input type="checkbox" name="customer_return_invoice_created_notify"
                                               id="customer_return_invoice_created_notify" value="1"
                                               @if($g_opt_value['customer_return_invoice_created_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Return Invoice Edited <span class="badge badge-info">customer SMS</span></div>
                                <div>
                                    <!-- Rounded switch -->
                                    <label class="switch">
                                        <input type="checkbox" name="customer_return_invoice_edited_notify"
                                               id="customer_return_invoice_edited_notify" value="1"
                                               @if($g_opt_value['customer_return_invoice_edited_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Return Invoice Canceled <span class="badge badge-info">customer SMS</span></div>
                                <div>

                                    <label class="switch">
                                        <input type="checkbox" name="customer_return_invoice_canceled_notify"
                                               id="customer_return_invoice_canceled_notify" value="1"
                                               @if($g_opt_value['customer_return_invoice_canceled_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <div>Cash Approval <span class="badge badge-info">customer SMS</span></div>
                                <div>
                                    <!-- Rounded switch -->
                                    <label class="switch">
                                        <input type="checkbox" name="customer_cash_approval_notify"
                                               id="customer_cash_approval_notify" value="1"
                                               @if($g_opt_value['customer_cash_approval_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>


                            <div class="w-100 text-center mb-3"><h4>Delivery Agent SMS Notification</h4></div>
                            <div class="d-flex justify-content-between mb-3">
                                <div>Sales Invoice Created <small class="badge badge-dark">Delivery Agent</small></div>
                                <div>
                                    <label class="switch">
                                        <input type="checkbox" name="d_agent_sales_invoice_created_notify"
                                               id="d_agent_sales_invoice_created_notify" value="1"
                                               @if($g_opt_value['d_agent_sales_invoice_created_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">

                                <div>Sales Invoice Edited <small class="badge badge-dark">Delivery Agent</small></div>
                                <div>
                                    <label class="switch">
                                        <input type="checkbox" name="d_agent_sales_invoice_edited_notify"
                                               id="d_agent_sales_invoice_edited_notify" value="1"
                                               @if($g_opt_value['d_agent_sales_invoice_edited_notify'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <div>Is Delivery Agent Sales Invoice SMS Notification Includes Product Information</div>
                                <div><label class="switch">
                                        <input type="checkbox" name="d_agent_sales_invoice_includes_product"
                                               id="d_agent_sales_invoice_includes_product" value="1"
                                               @if($g_opt_value['d_agent_sales_invoice_includes_product'] == 1) checked @endif>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="d_agent_list_sales_invoice_notify mb-3">Select Delivery Agent for SMS
                                    notification</label>
                                <select class="w-100" name="d_agent_list_sales_invoice_notify[]"
                                        id="d_agent_list_sales_invoice_notify" multiple>
                                    @foreach($admins as $admin)
                                        <option value="{{$admin->id}}"
                                                @if(count($g_opt_value['d_agent_list_sales_invoice_notify']) > 0)
                                                @foreach($g_opt_value['d_agent_list_sales_invoice_notify'] as $admin_id)
                                                @if((int) $admin_id === (int) $admin->id)    selected @endif
                                            @endforeach
                                            @endif
                                        >{{$admin->name .' - ('.$admin->phone.')'}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success  mt-5" id="update_button">Update</button>
                        </div>
                    </form>
                </div>
                <!-- card body end -->

            </div>

        </div>
    </div>


@endsection

@push('js')
    <script>
        $('#general_option_form').submit(function () {
            $("#update_button").html('<i class="fas fa-spinner fa-spin"></i> Please Wait........').addClass("disabled");
        });

        $("#admin_list_sales_invoice_created_notify").select2({
            width: '100%',
        });

        $("#admin_list_sales_invoice_edited_notify").select2({
            width: '100%',
        });

        $("#admin_list_sales_invoice_canceled_notify").select2({
            width: '100%',
        });

        $("#admin_list_return_invoice_created_notify").select2({
            width: '100%',
        });

        $("#admin_list_return_invoice_edited_notify").select2({
            width: '100%',
        });

        $("#admin_list_return_invoice_canceled_notify").select2({
            width: '100%',
        });
        $("#d_agent_list_sales_invoice_notify").select2({
            width: '100%',
        });

        $("#admin_list_email_sales_invoice_created").select2({
            width: '100%',
        });
        $("#admin_list_email_sales_invoice_edited").select2({
            width: '100%',
        });
        $("#admin_list_email_return_invoice_created").select2({
            width: '100%',
        });
        $("#admin_list_email_return_invoice_edited").select2({
            width: '100%',
        });
        $("#admin_list_daily_order_created_notify").select2({
            width: '100%',
        });
        $("#admin_list_daily_order_edited_notify").select2({
            width: '100%',
        });

        $("#admin_daily_order_created_notify").change(function () {
            if ($(this).prop("checked") == true) {
                $(".admin_daily_order_created_wrapper").show();
            } else if ($(this).prop("checked") == false) {
                $(".admin_daily_order_created_wrapper").hide();
            }
        });

        $("#admin_daily_order_edited_notify").change(function () {
            if ($(this).prop("checked") == true) {
                $(".admin_daily_order_edited_wrapper").show();
            } else if ($(this).prop("checked") == false) {
                $(".admin_daily_order_edited_wrapper").hide();
            }
        });

        $("#admin_email_sales_invoice_created").change(function () {
            if ($(this).prop("checked") == true) {
                $(".admin_email_sales_invoice_created_wrapper").show();
            } else if ($(this).prop("checked") == false) {
                $(".admin_email_sales_invoice_created_wrapper").hide();
            }
        });

        $("#admin_email_sales_invoice_edited").change(function () {
            if ($(this).prop("checked") == true) {
                $(".admin_email_sales_invoice_edited_wrapper").show();
            } else if ($(this).prop("checked") == false) {
                $(".admin_email_sales_invoice_edited_wrapper").hide();
            }
        });

        $("#admin_email_return_invoice_created").change(function () {
            if ($(this).prop("checked") == true) {
                $(".admin_email_return_invoice_created_wrapper").show();
            } else if ($(this).prop("checked") == false) {
                $(".admin_email_return_invoice_created_wrapper").hide();
            }
        });
        $("#admin_email_return_invoice_edited").change(function () {
            if ($(this).prop("checked") == true) {
                $(".admin_email_return_invoice_edited_wrapper").show();
            } else if ($(this).prop("checked") == false) {
                $(".admin_email_return_invoice_edited_wrapper").hide();
            }
        });


        $("#inv_diff_invoice_heading").change(function () {
            if ($(this).prop("checked") == true) {
                $(".diff_inv_input").show();
            } else if ($(this).prop("checked") == false) {
                $(".diff_inv_input").hide();
            }
        });

        $("#admin_sales_invoice_created_notify").change(function () {
            if ($(this).prop("checked") == true) {
                $(".admin_sales_invoice_created_wrapper ").show();
            } else if ($(this).prop("checked") == false) {
                $(".admin_sales_invoice_created_wrapper ").hide();
            }
        });


        $("#admin_sales_invoice_edited_notify").change(function () {
            if ($(this).prop("checked") == true) {
                $(".admin_sales_invoice_edited_wrapper ").show();
            } else if ($(this).prop("checked") == false) {
                $(".admin_sales_invoice_edited_wrapper ").hide();
            }
        });

        $("#admin_sales_invoice_canceled_notify").change(function () {
            if ($(this).prop("checked") == true) {
                $(".admin_sales_invoice_canceled_wrapper ").show();
            } else if ($(this).prop("checked") == false) {
                $(".admin_sales_invoice_canceled_wrapper ").hide();
            }
        });

        $("#admin_return_invoice_created_notify").change(function () {
            if ($(this).prop("checked") == true) {
                $(".admin_return_invoice_created_wrapper ").show();
            } else if ($(this).prop("checked") == false) {
                $(".admin_return_invoice_created_wrapper ").hide();
            }
        });

        $("#admin_return_invoice_edited_notify").change(function () {
            if ($(this).prop("checked") == true) {
                $(".admin_return_invoice_edited_wrapper ").show();
            } else if ($(this).prop("checked") == false) {
                $(".admin_return_invoice_edited_wrapper ").hide();
            }
        });

        $("#admin_return_invoice_canceled_notify").change(function () {
            if ($(this).prop("checked") == true) {
                $(".admin_return_invoice_canceled_wrapper ").show();
            } else if ($(this).prop("checked") == false) {
                $(".admin_return_invoice_canceled_wrapper ").hide();
            }
        });

        function incrementDaysLimit() {
            let pd_limit = document.querySelector("#sms_delay_in_days");
            let pd_limit_value = pd_limit.value;
            $("#sms_delay_in_days").val(parseFloat(pd_limit_value) + 1);
        }

        function decrementDaysLimit() {
            let pd_limit = document.querySelector("#sms_delay_in_days");
            let pd_limit_value = pd_limit.value;
            let new_limit_value = parseFloat(pd_limit_value) - 1;
            if (new_limit_value > 0) {
                $("#sms_delay_in_days").val(new_limit_value);
            } else {
                return false;
            }
        }

    </script>
@endpush

@push('css')
    @if($g_opt_value['inv_diff_invoice_heading'] == 0)
        <style>
            .diff_inv_input {
                display: none;
            }
        </style>
    @endif
@endpush
