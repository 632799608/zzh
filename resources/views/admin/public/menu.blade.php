<aside class="Hui-aside">
	<input runat="server" id="divScrollValue" type="hidden" value="" />
	<div class="menu_dropdown bk_2">
		@foreach($menu['parent'] as $k)
		<dl id="menu-admin">
			<dt>
				@if (in_array($k['id'],$user['permission_id']))
					<i class="Hui-iconfont">&#xe62d;</i>
					{{ $k['display_name'] }}
					<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i>
				@endif
			</dt>
			<dd>
				<ul>
				  @foreach($menu['children'] as $v)
                    @if (in_array($v['id'],$user['permission_id']))
					    @if($v['parent_id'] == $k['id'])
						    <li>
								<a _href="/{{ $v['name'] }}" data-title="{{ $v['display_name'] }}" href="javascript:void(0)">
								    {{ $v['display_name'] }}
								</a>
						    </li>
						@endif
					@endif
				  @endforeach
				</ul>
			</dd>
		</dl>
		@endforeach
	</div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
	<div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
		<div class="Hui-tabNav-wp">
			<ul id="min_title_list" class="acrossTab cl">
				<li class="active"><span title="我的桌面" data-href="welcome.html">我的桌面</span><em></em></li>
			</ul>
		</div>
		<div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
	</div>
	<div id="iframe_box" class="Hui-article">
		<div class="show_iframe">
			<div style="display:none" class="loading"></div>
			<iframe scrolling="yes" frameborder="0" src=""></iframe>
		</div>
	</div>
</section>