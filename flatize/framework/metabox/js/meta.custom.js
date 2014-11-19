
(function($){
  var PGL_LayoutImage_Sidebar = function(id){
    $left = $('.cmb_metabox [class*="pgl_page_left_sidebar"]');
    $right = $('.cmb_metabox [class*="pgl_page_right_sidebar"]');
    switch(id){
      case 1:
        $left.hide();
        $right.hide();
        break;
      case 2:
        $left.show();
        $right.hide();
        break;
      case 3:
        $left.hide();
        $right.show();
        break;
      case 4:
        $left.show();
        $right.show();
        break;
      case 5:
        $left.show();
        $right.show();
        break;
      case 6:
        $left.show();
        $right.show();
        break;
      default:
        $left.hide();
        $right.hide();
        break;
    }
    $('.cmb_select').chosen({
      no_results_text: "Oops, nothing found!"
    });
  }

  var PGL_Swich_Page_layout = function(){
    var check = $('#page_template').val();
    var arr = ['cmb_id__pgl_page_layout','cmb_id__pgl_blog_skin','cmb_id__pgl_blog_count','cmb_id__pgl_page_left_sidebar','cmb_id__pgl_page_right_sidebar','cmb_id__pgl_show_title'];
    var arrblog = ['cmb_id__pgl_page_layout','cmb_id__pgl_blog_skin','cmb_id__pgl_blog_count','cmb_id__pgl_show_title','cmb_id__pgl_show_breadcrumb'];
    var arrshow = ['cmb_id__pgl_page_layout','cmb_id__pgl_show_title','cmb_id__pgl_show_breadcrumb'];
    if( check=='template-visual.php' ){
      $.each(arr,function(index,value){
        $('.'+value).hide();
      });
    }else if(check=='template-blog.php'){
       $.each(arrblog,function(index,value){
        $('.'+value).show();
      });
    }else{
      $.each(arr,function(index,value){
        $('.'+value).hide();
      });
      $.each(arrshow,function(index,value){
        $('.'+value).show();
      });
      var id =  parseInt($('#_pgl_page_layout').val()) ;
      PGL_LayoutImage_Sidebar(id);
    }
  }

  $(document).ready(function(){
    PGL_Swich_Page_layout();
    PGL_LayoutImage_Sidebar(parseInt($('#_pgl_page_layout').val()));

    $('#page_template').change(function(){
      PGL_Swich_Page_layout();
    });


    $('.layout-image img').click(function(){
      $('.layout-image img').removeClass('active');
      var $val = $(this).addClass('active').data('value');
      $(this).parent().next().val($val);
      PGL_LayoutImage_Sidebar($val);
    });

    $('.cmb_select').chosen({
      no_results_text: "Oops, nothing found!"
    });
  });
})(jQuery)
  


if (typeof jQuery === "undefined") { throw new Error("Bootstrap's JavaScript requires jQuery") }


+function ($) {
  'use strict';

  // BUTTON PUBLIC CLASS DEFINITION
  // ==============================

  var Button = function (element, options) {
    this.$element  = $(element)
    this.options   = $.extend({}, Button.DEFAULTS, options)
    this.isLoading = false
  }

  Button.VERSION  = '3.2.0'

  Button.DEFAULTS = {
    loadingText: 'loading...'
  }

  Button.prototype.setState = function (state) {
    var d    = 'disabled'
    var $el  = this.$element
    var val  = $el.is('input') ? 'val' : 'html'
    var data = $el.data()

    state = state + 'Text'

    if (data.resetText == null) $el.data('resetText', $el[val]())

    $el[val](data[state] == null ? this.options[state] : data[state])

    // push to event loop to allow forms to submit
    setTimeout($.proxy(function () {
      if (state == 'loadingText') {
        this.isLoading = true
        $el.addClass(d).attr(d, d)
      } else if (this.isLoading) {
        this.isLoading = false
        $el.removeClass(d).removeAttr(d)
      }
    }, this), 0)
  }

  Button.prototype.toggle = function () {
    var changed = true
    var $parent = this.$element.closest('[data-toggle="buttons"]')

    if ($parent.length) {
      var $input = this.$element.find('input')
      if ($input.prop('type') == 'radio') {
        if ($input.prop('checked') && this.$element.hasClass('active')) changed = false
        else $parent.find('.active').removeClass('active')
      }
      if (changed) $input.prop('checked', !this.$element.hasClass('active')).trigger('change')
    }

    if (changed) this.$element.toggleClass('active')
  }


  // BUTTON PLUGIN DEFINITION
  // ========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.button')
      var options = typeof option == 'object' && option

      if (!data) $this.data('bs.button', (data = new Button(this, options)))

      if (option == 'toggle') data.toggle()
      else if (option) data.setState(option)
    })
  }

  var old = $.fn.button

  $.fn.button             = Plugin
  $.fn.button.Constructor = Button


  // BUTTON NO CONFLICT
  // ==================

  $.fn.button.noConflict = function () {
    $.fn.button = old
    return this
  }


  // BUTTON DATA-API
  // ===============

  $(document).on('click.bs.button.data-api', '[data-toggle^="button"]', function (e) {
    var $btn = $(e.target)
    if (!$btn.hasClass('btn')) $btn = $btn.closest('.btn')
    Plugin.call($btn, 'toggle')
    e.preventDefault()
  });

}(jQuery);
