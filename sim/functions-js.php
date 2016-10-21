		<script language="JavaScript" type="text/javascript">
		//** funció d'estil BBcodes */
			function emoticon(text) {
			text = '' + text + '';
				if (document.post.message.createTextRange && document.post.message.caretPos) {
					var caretPos = document.post.message.caretPos;
					caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
					document.post.message.focus();
				} else {
					document.post.message.value  += text;
					document.post.message.focus();
				}
			}
			
		//** funcions de marcar i desmarcar grups de checkboxs */
			function marcar() {
			for(i=0;i<document.formulari.elements.length;i++)
				if(document.formulari.elements[i].type=="checkbox" && document.formulari.elements[i].id=="chequea")
					document.formulari.elements[i].checked=1
			}
			function marcar_perso() {
			for(i=0;i<document.formulari.elements.length;i++)
				if(document.formulari.elements[i].type=="checkbox" && document.formulari.elements[i].id=="chequea_perso")
					document.formulari.elements[i].checked=1
			}
			function desmarcar() {
			for(i=0;i<document.formulari.elements.length;i++)
				if(document.formulari.elements[i].type=="checkbox" && document.formulari.elements[i].id=="chequea")
					document.formulari.elements[i].checked=0
			}
			function desmarcar_perso() {
			for(i=0;i<document.formulari.elements.length;i++)
				if(document.formulari.elements[i].type=="checkbox" && document.formulari.elements[i].id=="chequea_perso")
					document.formulari.elements[i].checked=0
			}

		//** funcions obrir finestra*/
			function NewWindow(mypage, myname, w, h, scroll) {
				var winl = (screen.width - w) / 2;
				var wint = (screen.height - h) / 2;
				winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizable'
				win = window.open(mypage, myname, winprops)
				if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
				}


			function limitarSeleccion() {
				var contador = 0;
				for (i=0;i<document.formulari.elements.length;i++)
				{
					if (document.formulari.elements[i].checked == 1)
					{
						contador++;
					}
					if (contador > 2)
					{
						for (i=0;i<document.formulari.elements.length;i++)
						{
							document.formulari.elements[i].checked = false;
						}
					}
				}
			}

			function redireccionar(){
				 window.history.back();
			}
		
		//** Funciones desplegables combinados */
			function desplegableCombinado(){
				if (document.getElementById('id_servicio2').value!=0){document.getElementById('id_cliente').value=0;}
				if (document.getElementById('id_cliente').value!=0){document.getElementById('id_cliente').value=0;}
				document.forms.form1.action='';
				document.forms.form1.method='POST';
				document.forms.form1.submit();
			}

			function desplegableCombinado2(){
				if (document.getElementById('id_cliente').value!=0){
					document.getElementById('id_servicio').value=0;
				}
				document.forms.form1.action='';
				document.forms.form1.method='POST';
				document.forms.form1.submit();
			}

			function desplegableCombinado3($service2){
				if ($service2!=0){document.getElementById('id_servicio').value=0;}
				document.forms.form1.action='';
				document.forms.form1.method='POST';
				document.forms.form1.submit();
			}

			function desplegableCombinado4($id_usuario_origen){
				if ($id_usuario_origen!=0){document.getElementById('id_servicio').value=0;}
				document.forms.form1.action='';
				document.forms.form1.method='POST';
				document.forms.form1.submit();
			}

			function desplegableCombinado5(){
				document.forms.form2.action='';
				document.forms.form2.target='';
				document.forms.form2.method='POST';
				document.forms.form2.submit();
			}

		</script>

		<script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
		<script type="text/javascript">
		// ** Funciones editor de texto WYSIWYG
			tinymce.init({
			  selector: '.contenidos',
			  height: 200,
			  plugins: [
				"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
				"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				"table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
			  ],

			  toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
			  toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
			  toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

			  menubar: false,
			  toolbar_items_size: 'small',

			  style_formats: [{
				title: 'Bold text',
				inline: 'b'
			  }, {
				title: 'Red text',
				inline: 'span',
				styles: {
				  color: '#ff0000'
				}
			  }, {
				title: 'Red header',
				block: 'h1',
				styles: {
				  color: '#ff0000'
				}
			  }, {
				title: 'Example 1',
				inline: 'span',
				classes: 'example1'
			  }, {
				title: 'Example 2',
				inline: 'span',
				classes: 'example2'
			  }, {
				title: 'Table styles'
			  }, {
				title: 'Table row 1',
				selector: 'tr',
				classes: 'tablerow1'
			  }],

			  templates: [{
				title: 'Test template 1',
				content: 'Test 1'
			  }, {
				title: 'Test template 2',
				content: 'Test 2'
			  }],
			  content_css: [
				'//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
				'//www.tinymce.com/css/codepen.min.css'
			  ]
			});
		</script>
