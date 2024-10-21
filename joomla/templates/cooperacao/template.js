/**
  .                                                               
  ######   ####  ### ##  ###  ####
   #   #  ##  ##  ## #  #   #  # #
   #   #  #    #   ##   #####  #  
   #   #  ##  ##  # ##  #      #  
  ### ###  ####  ## ###  #### ###.  
                                                                                                                                                                                                                                 
 *.
 * @author: Noxer - Sistemas e Tecnologias da Informação.
 * @site: https://www.dril.com.br/.
 * @email: contato@dril.com.br.
 * @date: 2024/09/19.
 * @language: Português e Inglês.
 * @job: HTML5/CSS3/JS.
 * @tools: PHP8.
 * 
 * Copyright(c) Todos os direitos reservados.
 *.
**/

if (window.console == null) window.console = { log: function(p) { } };

var self;

var Functions = function(){
	self = this;
	self.init();
}

Functions.fn = Functions.prototype;
Functions.fn.extend = jQuery.extend;
Functions.fn.extend({
  init: function(){

	$('header div.posicao a.btMenu').click(function(){
		$('header nav').slideToggle('fast');
		return false;
	});

	$('section.fichaTecnica div.titulo a').click(function(){
		$(this).toggleClass('active');
		$('section.fichaTecnica #detalhe_ficha').slideToggle('fast');
		return false;
	});

	$('section.home .slider').slick({
		infinite: true,
		slidesToShow: 2,
		slidesToScroll: 1,
		dots: true,
		arrows: false,
		variableWidth: false,
		centerPadding: 50,
		responsive: [{
		  breakpoint: 500,
		  settings: {
		  slidesToShow: 1,
		  slidesToScroll: 1,
		  }
		}]
	  });
    
    $('section.cases .slider').slick({
		  infinite: true,
		  slidesToShow: 3,
		  slidesToScroll: 1,
		  dots: false,
		  arrows: true,
		  variableWidth: false,
		  responsive: [{
			breakpoint: 500,
			settings: {
			slidesToShow: 1,
			slidesToScroll: 1,
			}
		  }]
		});

    $('section.noticias .slider').slick({
		  infinite: true,
		  slidesToShow: 4,
		  slidesToScroll: 1,
		  dots: false,
		  arrows: true,
		  variableWidth: false,
		  responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
          ]
		});

	}
});

jQuery(function(){
	functions = new Functions();
});
