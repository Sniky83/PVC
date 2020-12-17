<script type="text/javascript">
		const xhr = new XMLHttpRequest();

		xhr.onload = function() {
			const serverReponse = document.getElementById("test");
			serverReponse.innerHTML = this.responseText;
		};

		xhr.open("POST","./test.php");
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("vehicule='.$_POST["vehicule"].'&typeMesure='.$_POST["typeMesure"].'&affichage='.$_POST["affichage"].'");
	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#formulaire").submit(function(){
			vehicule = $(this).find("select[name=vehicule]").val();
			type = $(this).find("select[name=typeMesure]").val();
			affichage = $(this).find("input[name=affichage]").val();
			$.post("mesures.php",{vehicule: vehicule, type: type, affichage: affichage},function(data){

				});
			return false;
		});
	});
</script>