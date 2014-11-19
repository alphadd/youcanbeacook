
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<div class="pgl_search">
		<input name="s" id="s" maxlength="20" class="form-control " type="text" size="20" placeholder="Search...">
        <input type="submit" id="searchsubmit" value="Search" />
        <i class="fa fa-search"></i>
        <input type="hidden" name="post_type" value="product" />
	</div>
</form>