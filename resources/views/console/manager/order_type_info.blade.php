@if($info['parent_order']['cooperation_mode'])
    <div class="item_f"><p><i class="LGntas"></i>合作方式：</p>
        <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ $info['parent_order']['cooperation_mode'] }}"></div>
    </div>
@endif
<div class="item_f"><p><i class="LGntas"></i>@if($info['type_id'] == 10) 直播标题@else 稿件名称@endif：</p>
    <div class="r"><input type="text" readonly="readonly" value="{{ $info['parent_order']['title'] }}" id="textfield" class="txt_f1" style="width:52%;"></div>
</div>
<div class="item_f"><p><i class="LGntas"></i>开始时间：</p>
    <div class="r"><input type="text" readonly="readonly" id="datepicker1" class="txt_f1" value="{{ $info['parent_order']['start_at'] }}"></div>
</div>
<div class="item_f"><p><i class="LGntas"></i>结束时间：</p>
    <div class="r"><input type="text" readonly="readonly" id="datepicker2" class="txt_f1" value="{{ $info['parent_order']['over_at'] }}"></div>
</div>
        {{-- kaishi --}}
@if($info['type_id'] == 10) 
    <div class="item_f"><p><i class="LGntas"></i>具体形式：</p>
        <div class="r radio_w">
            <label class="rd1 @if($info['parent_order']['doc_type'] ==1) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==1) checked="checked" @endif value="1" disabled />活动现场直播</label>
            <label class="rd1 @if($info['parent_order']['doc_type'] ==2) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==2) checked="checked" @endif  value="2" disabled />产品使用</label>
            <label class="rd1 @if($info['parent_order']['doc_type'] ==3) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==3) checked="checked" @endif  value="3" disabled />店铺体验</label>
            <label class="rd1 @if($info['parent_order']['doc_type'] ==4) css_cur @endif"><input type="radio" name="edit_type" class="radio_f" @if($info['parent_order']['doc_type'] ==4) checked="checked" @endif  value="3" disabled />游戏直播</label>
        </div>
    </div>
    <div class="item_f" style=""><p><i class="LGntas"></i>直播内容：</p>
        <div class="r">
            <div class="dnts">{!! $info['parent_order']['content'] !!}</div>
        </div>
    </div>
    <div class="item_f"><p><i class="LGntas"></i>直播地点：</p>
        <div class="r"><input type="text" name="textfield" id="textfield" disabled="disabled" class="txt_f1" value="{{ $info['parent_order']['cooperation_place'] }}"  style="width:52%;"></div>
    </div>
    @if($info['parent_order']['sale_file'])
        <div class="item_f" style=""><p><i class="LGntas"></i>上传附件：</p>
            <div class="r">
               <a href="/{{$info['parent_order']['sale_file']}}" target="view_window" class="txt_f1" style="line-height:45px; width:75%; float:left;">{{$info['parent_order']['sale_file']}}</a>
            </div>
        </div>
    @endif
@else
    <div class="item_f"><p><i class="LGntas"></i>编辑方式{{ $info['parent_order']['doc_type'] }}：</p>
        <div class="r radio_w disabled_rd">
            <label class="rd1 @if($info['parent_order']['doc_type'] == 1) css_cur  @endif"><input type="radio" disabled="disabled" class="radio_f" value="1" @if($info['parent_order']['doc_type'] == 1) checked  @endif />外部链接</label>
            <label class="rd1 @if($info['parent_order']['doc_type'] == 2) css_cur  @endif"><input type="radio" disabled="disabled" class="radio_f" value="2" @if($info['parent_order']['doc_type'] == 2) checked  @endif />上传文档</label>
            <label class="rd1 @if($info['parent_order']['doc_type'] == 3) css_cur  @endif"><input type="radio" disabled="disabled" class="radio_f" value="3" @if($info['parent_order']['doc_type'] == 3) checked  @endif/>内部编辑</label>
        </div>
    </div>

    <div id="body_edit_type">
        <div id="body_edit_type">
            <div class="item_f" @if($info['parent_order']['doc_type'] == 1) style="display:block;" @else style="display: none" @endif>
                <p><i class="LGntas"></i>外部链接：</p>
                <div class="r">
                    <input type="text" class="txt_f1" style="width:75%;" value="{{ $info['parent_order']['content'] }}" />
                </div>
            </div>
            <div class="item_f" @if($info['parent_order']['doc_type'] == 2) style="display:block;" @else style="display: none" @endif>
                <p><i class="LGntas"></i>文档导入：</p>
                <div class="r">
                    <a href="/{{ $info['parent_order']['content'] }}" target="view_window" class="txt_f1" style="line-height:45px; width:75%; float:left;">{{$info['parent_order']['content']}}</a >
                </div>
            </div>
            <div class="item_f" @if($info['parent_order']['doc_type'] == 3) style="display:block;" @else style="display: none" @endif>
                <p><i class="LGntas"></i>稿件需求：</p>
                <div class="r">
                    <div class="txt_ft1">{!! $info['parent_order']['content'] !!}</div>
                </div>
            </div>
        </div>
    </div>
@endif