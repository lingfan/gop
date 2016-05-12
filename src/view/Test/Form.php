<form method="post" action="?r=Test/Index" class="pageForm required-validate"
      onsubmit="return validateCallback(this, dialogAjaxDone)">
	<div class="pageFormContent" layoutH="56">
		<p>
			<label><?php echo LangConst::T('EMail'); ?>：</label>
			<input class="required email" name="email" type="text" size="30"/>
		</p>

		<p>
			<label><?php echo LangConst::T('客户名称'); ?>：</label>
			<input class="required" name="name" type="text" size="30"/>
		</p>
	</div>
	<div class="formBar">
		<ul>
			<li>
				<div class="buttonActive">
					<div class="buttonContent">
						<button type="submit"><?php echo LangConst::T('保存'); ?></button>
					</div>
				</div>
			</li>
			<li>
				<div class="button">
					<div class="buttonContent">
						<button type="Button" class="close"><?php echo LangConst::T('取消'); ?></button>
					</div>
				</div>
			</li>
		</ul>
	</div>
</form>