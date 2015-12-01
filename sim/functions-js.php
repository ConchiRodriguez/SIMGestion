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
		</script>