<html>
  <body>
    <script src="../node_modules/luhn-generator/dist/luhn.js"></script>
    <script>
      //console.log(luhn.generate(35790509, { pad: 15 })); // 000000000018
      //console.log(luhn.random(7));

      /*for(var i=0; i<=10; i++){
		console.log(luhn.generate(7, { pad: 6 }, 123456));
      }*/
      	//var imei=[123456, 3388651];

      	/*for(var i=0; i<imei.length; i++){
      		console.log(luhn.validate(imei[i])+imei[i]);
      	}*/

      	var imei_number="356252073388651";
		console.log(luhn.validate(imei_number));


      
    </script>


        <div id="dvImportSegments" class="fileupload ">
            <fieldset>
                <legend>Upload your CSV File</legend>
                <input type="text" placeholder="tac no" id="tac_no"/>
                <input type="file" name="File Upload" id="txtFileUpload" accept=".csv" />
            </fieldset>

            <div class="exported_details">
                <div class="correct_imeis"></div>
                <div class="wrong_imeis"></div>

                <button onclick="exportToCsv()">export to CSV (Correct IMEIs)</button>
            </div>

        </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/jquery.csv.js"></script>

    <script type="text/javascript">
          $(document).ready(function() {
              $(".exported_details").hide();
              var correct_imeis=[];
              var wrong_imeis=[];
              var correct_imeis_two=[];

              // The event listener for the file upload
              document.getElementById('txtFileUpload').addEventListener('change', upload, false);

              // Method that checks that the browser supports the HTML5 File API
              function browserSupportFileUpload() {
                  var isCompatible = false;
                  if (window.File && window.FileReader && window.FileList && window.Blob) {
                      isCompatible = true;
                  }
                  return isCompatible;
              }

              // Method that reads and processes the selected file
              function upload(evt) {
                  var tac_number=$("#tac_no").val();
                  if(tac_number==""){
                    alert("Please provide TAC number");
                  }
                  else{
                      $(".exported_details").hide();
                      if (!browserSupportFileUpload()) {
                          alert('The File APIs are not fully supported in this browser!');
                      }
                      else {
                          var data = null;
                          var file = evt.target.files[0];
                          var reader = new FileReader();
                          reader.readAsText(file);
                          reader.onload = function(event) {
                              var csvData = event.target.result;
                              data = $.csv.toArrays(csvData);
                              console.log(data);


                              if (data && data.length > 0) {
                                  alert('Imported -' + data.length + '- rows successfully!');
                                  //console.log(luhn.validate(data, 28));

                                  for(var i=0; i<data.length; i++){
                                      // alert(data[i][0]);
                                      if(luhn.validate(tac_number+data[i][0])==true){
                                          correct_imeis.push(tac_number+data[i][0]);
                                          //$("#correct_imeis").html(data[i][0]+"<br/>");
                                      }
                                      else{
                                          wrong_imeis.push(tac_number+data[i][0]);
                                      }
                                  }


                                  $(".correct_imeis").html("Correct IMEIs count: "+correct_imeis.length);
                                  $(".wrong_imeis").html("Wrong IMEIs count: "+wrong_imeis.length);


                                  console.log("correct IMEIS: "+correct_imeis);
                                  console.log("wrong IMEIS: "+wrong_imeis);

                                  while(correct_imeis.length){
                                      correct_imeis_two.push(correct_imeis.splice(0,2));
                                  }

                                  $(".exported_details").show();

                              } else {
                                  alert('No data to import!');
                              }
                          };
                          reader.onerror = function() {
                              alert('Unable to read ' + file.fileName);
                          };
                      }
                  }
              }


              exportToCsv = function() {
                  var CsvString = "";
                  correct_imeis_two.forEach(function(RowItem, RowIndex) {

                          CsvString += RowItem + ',';

                      CsvString += "\r\n";
                  });
                  CsvString = "data:application/csv," + encodeURIComponent(CsvString);
                  var x = document.createElement("A");
                  x.setAttribute("href", CsvString );
                  x.setAttribute("download","correctIMEIs.csv");
                  document.body.appendChild(x);
                  x.click();
              }
          });
  </script>
  </body>

</html>