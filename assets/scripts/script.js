function inizializza(){
    document.location = '#job_a';
    document.getElementById('game').style.visibility = 'visible';
    document.getElementById('job').style.visibility = 'visible';
    document.getElementById('fun').style.visibility = 'visible';

    //  Tremolio baloon BLOG e PEOPLE
    agita_baloon_blog(1);
        
        //  Colorbox
        $(".media").colorbox({iframe:true, innerWidth:740, innerHeight:560});

        $(".people").colorbox({iframe:true, innerWidth:342, innerHeight:183});

		$(window).load(function(){
			//  Preload di tutte le immagini
			$.preloadCssImages();
		
		});
	
	$.ajax({
		url: 'admin.php?m=Api&a=applist',
		success: function(value){
			value = eval(value);
			
				
				var r = [], nn;
				
				$.each(value, function(i, n){
					if(i % 4 == 0){
						
						nn = [];
						
						r.push(nn);
					}
					
					nn.push(
						['<div class="item"><h2><a href="',
						n.url,
						'" target="_blank">',
						n.name,
						'</a></h2><div class="description"><strong>提供: ',
						n.author,
						'</strong>- ',
						n.intro,
						'<br/><br/></div></div>'
					].join('')        );
					
					
				});
				
				$.each(r, function(i, n){
					r[i] = '<li class="block">' + n.join('<div class="sep">&nbsp;</div>') + '</li>';	
				});
				
				portofolio_numero_slide = r.length;
				
				for(var  i = 1; i <= portofolio_numero_slide; i++){
					$('#slider_nav').append('<div class="jFlowControl' + ( i == 1 ? ' active' : '')  + '" id="btn' + i + '" onclick="javascript:portofolio_slider(' + i + ');void(0);"> ' + i + '</div>');
				}
				
				r = '<ul id="slider_content_list">' + r.join('') + '</ul>';
				
				
				$('#slider_content').append(r);

				//  Slider game
				$("#slider_nav").jFlow({
					slides: "#slider_content_list",
					width: "868px",
					height: "110px",
					duration: 600
				});
				
				
		},
		error: function(value){
			
		}
	});
}


 $(inizializza);


var portofolio_numero_slide = 1;
function portofolio_slider(num){
    for(var i=1; i<=portofolio_numero_slide; i++){
        if(i==num){
            document.getElementById('btn'+i).className = 'jFlowControl active';
        }else{
            document.getElementById('btn'+i).className = 'jFlowControl';
        }
    }

    game_slide_attiva = num;
}

var game_slide_attiva = 1;

function portofolio_slider_next(){
    game_slide_attiva++;
    if(game_slide_attiva>portofolio_numero_slide){
        game_slide_attiva = 1;
    }
    portofolio_slider(game_slide_attiva);
}

function portofolio_slider_prev(){
    game_slide_attiva--;
    if(game_slide_attiva<1){
        game_slide_attiva = portofolio_numero_slide;
    }
    portofolio_slider(game_slide_attiva);
}


        
function contactFormValidation() {

	var nome = document.getElementById('form_nome').value;
	var email = document.getElementById('form_email').value;
	var testo = document.getElementById('form_testo').value;

	var emptyField = false;

	if(nome.length < 1 && email.length < 1){
            alert("输入用户名或联系方式");
            emptyField = true;
            return false;
        }
        if(testo.length < 1){
            alert("内容为空");
            emptyField = true;
            return false;
        }

        //  Tutto ok, invio l'email
        $.ajax({
            type: 'POST',
            url: 'admin.php?m=Api&a=comment',
            data: "name="+nome+"&email="+email+"&text="+testo,
            success: function(value) {
                alert(value || '感谢您的提交');
                document.getElementById('form_testo').value = '';
                nascondi_form();
            }
        });

	return false;

}

function mostra_form(){
    document.getElementById("form_open").style.display='none';
    $('#fun_form').animate({width: 700}, 200, '',
        function(){
            document.getElementById("form_nome").style.display='block';
            document.getElementById("form_email").style.display='block';
            document.getElementById("form_testo").style.display='block';
            document.getElementById("form_submit").style.display='block';
            document.getElementById("form_close").style.display='block';
        }
    );
}

function nascondi_form(){
    document.getElementById("form_nome").style.display='none';
    document.getElementById("form_email").style.display='none';
    document.getElementById("form_testo").style.display='none';
    document.getElementById("form_submit").style.display='none';
    $('#fun_form').animate({width: 0}, 200, '',
        function(){
            document.getElementById("form_open").style.display='block';
            document.getElementById("form_close").style.display='none';
        }
    );
}



var people_baloon_positions = [
    [651, 445],
    [651, 450],
    [651, 440],
    [656, 445],
    [656, 450],
    [656, 440],
    [646, 445],
    [646, 450],
    [646, 440]
]
var agita_baloon_people_interval_1 = null;
var agita_baloon_people_interval_2 = null;

function agita_baloon_people(velocita){
    switch(velocita){
        case 1:
            agita_baloon_people_interval_1 = window.setInterval(agita_baloon_people_submit, 50);
            break;
        case 2:
            agita_baloon_people_interval_2 = window.setInterval(agita_baloon_people_submit, 25);
            break;
    }
}

function agita_baloon_people_submit(){
    var position = Math.floor(Math.random()*9);

    document.getElementById('baloon_people').style.left = people_baloon_positions[position][0]+'px';
    document.getElementById('baloon_people').style.top = people_baloon_positions[position][1]+'px';
}

function ferma_baloon_people(){
    window.clearInterval(agita_baloon_people_interval_2)
}



var blog_baloon_positions = [
    [550, 392],
    [550, 390],
    [550, 394],
    [552, 392],
    [552, 390],
    [552, 394],
    [548, 392],
    [548, 390],
    [548, 394]
]
var agita_baloon_blog_interval_1 = null;
var agita_baloon_blog_interval_2 = null;

function agita_baloon_blog(velocita){
    switch(velocita){
        case 1:
            agita_baloon_blog_interval_1 = window.setInterval(agita_baloon_blog_submit, 65);
            break;
        case 2:
            agita_baloon_blog_interval_2 = window.setInterval(agita_baloon_blog_submit, 10);
            break;
    }
}

function agita_baloon_blog_submit(){
    var position = Math.floor(Math.random()*9);

    document.getElementById('baloon_blog').style.left = blog_baloon_positions[position][0]+'px';
    document.getElementById('baloon_blog').style.top = blog_baloon_positions[position][1]+'px';
}

function ferma_baloon_blog(){
    window.clearInterval(agita_baloon_blog_interval_2)
}