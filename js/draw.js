$(function () {

   var mamDraw = [];
   mamDraw.isMouseDown = false;
   mamDraw.position = [];
   mamDraw.position.x = 0;
   mamDraw.position.y = 0;
   mamDraw.position.px = 0;
   mamDraw.position.py = 0;

   // signeTitleをクリックすることでdrawのメソッドを呼び出す
   $("#signeTitle").on("click", function () {
      startDraw();
   });

   /**
    * 初期設定と実行の呼び出し
    */
   function startDraw() {
      //初期設定
      mamDraw.canvas = document.getElementById("canvas");
      window.addEventListener("mousemove", StopShake);

      mamDraw.canvas.addEventListener("touchstart", onDown);
      mamDraw.canvas.addEventListener("touchmove", onMove);
      mamDraw.canvas.addEventListener("touchend", onUp);
      mamDraw.canvas.addEventListener("mousedown", onMouseDown);
      mamDraw.canvas.addEventListener("mousemove", onMouseMove);
      mamDraw.canvas.addEventListener("mouseup", onMouseUp);

      mamDraw.context = mamDraw.canvas.getContext("2d");
      mamDraw.context.strokeStyle = "#000000";
      mamDraw.context.lineWidth = 5;
      mamDraw.context.lineJoin = "round";
      mamDraw.context.lineCap = "round";

      document.getElementById("clearCanvas").addEventListener("click", clearCanvas);
      document.getElementById("chgImg").addEventListener("click", chgImg);
   }

   /**
    * マウスイベント：
    * @param {*} event 
    */
   function StopShake(event) {
      mamDraw.isMouseDown = false;
      event.stopPropagation();
   }

   /**
    * マウスイベント：
    * @param {*} event 
    */
   function onDown(event) {
      mamDraw.isMouseDown = true;
      mamDraw.position.px = event.touches[0].pageX - event.target.getBoundingClientRect().left - mamGetScrollPosition().x;
      mamDraw.position.py = event.touches[0].pageY - event.target.getBoundingClientRect().top - mamGetScrollPosition().y;
      mamDraw.position.x = mamDraw.position.px;
      mamDraw.position.y = mamDraw.position.py;
      drawLine();
      event.preventDefault();
      event.stopPropagation();
   }

   /**
    * マウスイベント：
    * @param {*} event 
    */
   function onMove(event) {
      if (mamDraw.isMouseDown) {
         mamDraw.position.x = event.touches[0].pageX - event.target.getBoundingClientRect().left - mamGetScrollPosition().x;
         mamDraw.position.y = event.touches[0].pageY - event.target.getBoundingClientRect().top - mamGetScrollPosition().y;
         drawLine();
         mamDraw.position.px = mamDraw.position.x;
         mamDraw.position.py = mamDraw.position.y;
         event.stopPropagation();
      }
   }

   /**
    * マウスイベント：
    * @param {*} event 
    */
   function onUp(event) {
      mamDraw.isMouseDown = false;
      event.stopPropagation();
   }

   /**
    * マウスイベント：mouse down
    * @param {*} event 
    */
   function onMouseDown(event) {
      mamDraw.position.px = event.clientX - event.target.getBoundingClientRect().left;
      mamDraw.position.py = event.clientY - event.target.getBoundingClientRect().top;
      mamDraw.position.x = mamDraw.position.px;
      mamDraw.position.y = mamDraw.position.py;
      drawLine();
      mamDraw.isMouseDown = true;
      event.stopPropagation();
   }

   /**
    * マウスイベント：move
    * @param {*} event 
    */
   function onMouseMove(event) {
      if (mamDraw.isMouseDown) {
         mamDraw.position.x = event.clientX - event.target.getBoundingClientRect().left;
         mamDraw.position.y = event.clientY - event.target.getBoundingClientRect().top;
         drawLine();
         mamDraw.position.px = mamDraw.position.x;
         mamDraw.position.py = mamDraw.position.y;
         event.stopPropagation();
      }
   }

   /**
    * マウスイベント：mouse up
    * @param {*} event 
    */
   function onMouseUp(event) {
      mamDraw.isMouseDown = false;
      event.stopPropagation();
   }

   /**
    * 線を描く設定
    */
   function drawLine() {
      mamDraw.context.strokeStyle = "#000";
      mamDraw.context.lineWidth = 2;
      mamDraw.context.lineJoin = "round";
      mamDraw.context.lineCap = "round";
      mamDraw.context.beginPath();
      mamDraw.context.moveTo(mamDraw.position.px, mamDraw.position.py);
      mamDraw.context.lineTo(mamDraw.position.x, mamDraw.position.y);
      mamDraw.context.stroke();
   }

   /**
    * 描いた線の初クリア
    */
   function clearCanvas() {
      console.log("clea");
      mamDraw.context.fillStyle = "rgb(255,255,255)";
      mamDraw.context.fillRect(
         0, 0,
         mamDraw.canvas.getBoundingClientRect().width,
         mamDraw.canvas.getBoundingClientRect().height
      );
   }


   function chgImg() {
      var png = mamDraw.canvas.toDataURL();

      document.getElementById("newImg").src = png;
   }

   /**
    * 
    * @returns 
    */
   function mamGetScrollPosition() {
      return {
         "x": document.documentElement.scrollLeft || document.body.scrollLeft,
         "y": document.documentElement.scrollTop || document.body.scrollTop
      };
   }



});
