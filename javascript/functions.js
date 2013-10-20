$(document).ready(function()
{
	/*
	Mascaras nos inputs; Tem que importar o plugin Masked Inputs

	$("#campoData").mask("99/99/9999");

	$("#campoTelefone").mask("(999) 9999-9999"); 


	*/


	/* Begin Register function */
		// Applying masks
		$("#data_nasc").mask("99/99/9999");
		$("#tel_princ").mask("(99) 99999999?9");
		$("#tel_op").mask("(99) 99999999?9");
		$("#cnpj").mask("99.999.999/9999-99");
		$("#rg").mask("99.999.999-9");
		$("#cpf").mask("999.999.999-99");


		$("#rg").hide();
		$("#cpf").hide();
		$("#feminino").hide();
		$("#masculino").hide();
		$("#cnpj").hide();
		$("#label_rg").hide();
		$("#label_cpf").hide();
		$("#label_m").hide();
		$("#label_f").hide();
		$("#label_cnpj").hide();



		// Pessoa fisica
		$("#fisica").click(function()
		{
			
			$("#rg").slideToggle();
			$("#cpf").slideToggle();
			$("#masculino").slideToggle();
			$("#feminino").slideToggle();
			$("#cnpj").hide();
			$("#label_rg").slideToggle();
			$("#label_cpf").slideToggle();
			$("#label_m").slideToggle();
			$("#label_f").slideToggle();
			$("#label_cnpj").hide();
			$('#cpf').attr('required','true');
			$('#rg').attr('required','true');
			$('#cnpj').removeAttr('required');

		})


		// Pessoa juridica
		$("#juridica").click(function()
		{

			$("#rg").hide();
			$("#cpf").hide();
			$("#masculino").hide();
			$("#feminino").hide();
			$("#cnpj").slideToggle();
			$("#label_rg").hide();
			$("#label_cpf").hide();
			$("#label_m").hide();
			$("#label_f").hide();
			$("#label_cnpj").slideToggle();
			$('#rg').removeAttr('required');
			$('#cpf').removeAttr('required');
			$('#cpnj').attr('required','true');
			$('#masculino').removeAttr('required');
			$('#feminino').removeAttr('required');

		})


		$("#masculino").click(function()
		{
			$('#masculino').attr('required','true');
			$('#feminino').removeAttr('required');
		})

		$("#feminino").click(function()
		{
			$('#feminino').attr('required','true');
			$('#masculino').removeAttr('required');
		})
		
	/* End Register function */



	/* Begin Login function */
		$('#login-click').click(function()
		{
				$(this).next('#login-content').slideToggle();
				$(this).toggleClass('active');
				
				if ($(this).hasClass('active')) $(this).find('span').html('&#x25B2;')
					else $(this).find('span').html('&#x25BC;')
		})
	/* End Login function */


});

/* Begin Ajax suggests searching*/

//Gets the browser specific XmlHttpRequest Object


function getSearch()
{
	var item = document.getElementById('search_type').value;
	var search = document.getElementById('search').value;

	$.get('/php/getSearch.php?item=' + item + '&search=' + search, function(data)
	{
		$('#main_column').html(data).show();
	});
}


function editUser()
{

	$.get('/php/edit_user.php', function(data) {
		$('#edit_dados').html(data).show();
	});

}

function editUserData()
{
	$.post("/php/edit_user.php",
		{
			ed_endereco: $('#endereco').val(),
			ed_tel_princ: $('#tel_princ').val(),
			ed_tel_op: $('#tel_op').val()
		}, function(data) {
		
		if (data == "erro")
		{
			alert("Os dados estão iguais !\nCaso queira atualizar seus dados modifique o formulário.");
		}
		else if (data == "sucesso")
		{
			alert("Os dados foram alterados com sucesso.");
			$('.cp-endereco').text($('#endereco').val());
			$('.cp-tel-princ').text($('#tel_princ').val());
			$('.cp-tel-op').text($('#tel_op').val());
			hideEditUser();
		}
	});
}

function hideEditUser()
{
	document.getElementById('edit_dados').style.display="none";
}


/*
	Dropdown de pesquisa de Operadoras/Produtos/Serviços

	*/

	function getXmlHttpRequestObject()
	{
		if (window.XMLHttpRequest)
		{
			return new XMLHttpRequest();
		}
		
		else if(window.ActiveXObject)
		{
			return new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		else
		{
			alert("Your Browser Sucks!\nIt's about time to upgrade don't you think?");
		}
	}

	//Our XmlHttpRequest object to get the auto suggest
	var searchReq = getXmlHttpRequestObject();

	//Called from keyup on the search textbox.
	//Starts the AJAX request.
	function searchSuggest()
	{

		if (document.getElementById('search').value == "" )
		{
			document.getElementById('search_type').disabled=false;
			document.getElementById('suggests').style.display="none";

		}
		else
		{
			document.getElementById('search_type').disabled=true;
			document.getElementById('suggests').style.display="block";
		}
		
		if (searchReq.readyState == 4 || searchReq.readyState == 0)
		{
			var str = escape(document.getElementById('search').value);
			var str2 = escape(document.getElementById('search_type').value);
			searchReq.open("GET", 'php/searchSuggest.php?search=' + str + '&item=' + str2, true);
			searchReq.onreadystatechange = handleSearchSuggest;
			searchReq.send(null);
		}
	}

	//Called when the AJAX response is returned.
	function handleSearchSuggest()
	{
		if (searchReq.readyState == 4)
		{
			var ss = document.getElementById('suggests')
			
			ss.innerHTML = '';
			
			var str = searchReq.responseText.split("\n");
			
			for(i=0; i < str.length - 1; i++)
			{
				//Build our element string.  This is cleaner using the DOM, but
				//IE doesn't support dynamically added attributes.
				var suggest = '<a onclick="getSearch();" href="javascript:void(0);"><div onmouseover="javascript:suggestOver(this);" ';
				suggest += 'onmouseout="javascript:suggestOut(this);" ';
				suggest += 'onclick="javascript:setSearch(this.innerHTML);" ';
				suggest += 'class="suggest_link">' + str[i] + '</div></a>';
				ss.innerHTML += suggest;
			}
		}
	}

	//Mouse over function
	function suggestOver(div_value)
	{
		div_value.className = 'suggest_link_over';
	}
	//Mouse out function
	function suggestOut(div_value)
	{
		div_value.className = 'suggest_link';
	}


	//Click function
	function setSearch(value)
	{
		document.getElementById('search').value = value;
		document.getElementById('suggests').innerHTML = '';
		document.getElementById('suggests').style.display="none";
	}



	function searchSuggestEval()
	{
		
		if (document.getElementById('searchEval').value == "" )
		{
			document.getElementById('suggestsEval').style.display="none";
		}
		else
		{
			document.getElementById('suggestsEval').style.display="block";
		}
		
		if (searchReq.readyState == 4 || searchReq.readyState == 0)
		{
			var str = escape(document.getElementById('searchEval').value);
			var str2 = escape(document.getElementById('search_type_eval').value);
			searchReq.open("GET", 'php/searchSuggest.php?search=' + str + '&item=' + str2, true);
			searchReq.onreadystatechange = handleSearchSuggestEval;
			searchReq.send(null);
		}
	}

	//Called when the AJAX response is returned.
	function handleSearchSuggestEval()
	{
		if (searchReq.readyState == 4)
		{
			var ss = document.getElementById('suggestsEval')
			
			ss.innerHTML = '';
			
			var str = searchReq.responseText.split("\n");
			
			for(i=0; i < str.length - 1; i++)
			{
				//Build our element string.  This is cleaner using the DOM, but
				//IE doesn't support dynamically added attributes.
				var suggest = '<div onmouseover="javascript:suggestOver(this);" ';
				suggest += 'onmouseout="javascript:suggestOut(this);" ';
				suggest += 'onclick="javascript:setSearchEval(this.innerHTML);" ';
				suggest += 'class="suggest_link">' + str[i] + '</div>';
				ss.innerHTML += suggest;
			}
		}
	}

	//Mouse over function
	function suggestOver(div_value)
	{
		div_value.className = 'suggest_link_over';
	}
	//Mouse out function
	function suggestOut(div_value)
	{
		div_value.className = 'suggest_link';
	}


	//Click function
	function setSearchEval(value)
	{
		document.getElementById('searchEval').value = value;
		document.getElementById('suggestsEval').innerHTML = '';
		document.getElementById('suggestsEval').style.display = "none";
	}


	/* End Ajax suggests searching */
	
	
	//Function back history
	function voltarHistory()
	{
		window.history.back();
	}

	
	//Functions da avaliação
	function enviarAval()
	{
		if (document.getElementById('nota1').value == '' || document.getElementById('nota1').value == 0 || document.getElementById('nota2').value == '' || document.getElementById('nota2').value == 0 || document.getElementById('nota3').value == '' || document.getElementById('nota3').value == 0 ||document.getElementById('nota4').value == '' || document.getElementById('nota4').value == 0 || document.getElementById('nota5').value == '' || document.getElementById('nota5').value == 0) 
		{
			alert("Por favor, avalie todas as questões");
		}
	}

