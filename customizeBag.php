<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <title>Eira store | Tote Bag Designer</title>
  <script src="https://kit.fontawesome.com/d5f0c685f3.js" crossorigin="anonymous"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: rgba(236, 227, 239, 0.996);
      font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
      padding: 2rem 1.5rem;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .app {
      max-width: 1280px;
      width: 100%;
      background: white;
      border-radius: 2rem;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
      overflow: hidden;
    }

    .header {
      padding: 1.5rem 2rem;
      border-bottom: 1px solid #efe5f2;
      display: flex;
      justify-content: space-between;
      align-items: baseline;
      flex-wrap: wrap;
      gap: 0.5rem;
    }
    .header h1 {
       font-size: 1.9rem;
      font-weight: 700;
      background: linear-gradient(135deg, #4A2C5F, #8460A8);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    .store-badge {
      background: #f3edf7;
      padding: 0.3rem 1rem;
      border-radius: 40px;
      font-size: 0.85rem;
      font-weight: 500;
      color: #4e2b63;
    }
    .sub {
      color: #5d4b6e;
      font-size: 0.85rem;
      margin-top: 0.2rem;
    }

    .main-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      padding: 2rem;
    }

    .preview {
      flex: 1.2;
      min-width: 280px;
      background: #fefafd;
      border-radius: 1.5rem;
      padding: 1.5rem;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .preview-label {
      font-weight: 500;
      color: #3d2a4e;
      margin-bottom: 1rem;
      font-size: 0.9rem;
    }
    canvas {
      display: block;
      width: 100%;
      max-width: 500px;
      height: auto;
      background: #fff9fc;
      border-radius: 24px;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
    }

    .controls {
      flex: 0.9;
      min-width: 260px;
      background: #ffffff;
      border-radius: 1.5rem;
    }

    .control-block {
      margin-bottom: 1.6rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid #eee7f2;
    }
    .control-label {
      font-weight: 600;
      font-size: 0.85rem;
      color: #3a2a48;
      margin-bottom: 0.6rem;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .color-row {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    input[type="color"] {
      width: 48px;
      height: 48px;
      border: 1px solid #ddd2e4;
      border-radius: 30px;
      cursor: pointer;
      background: white;
    }
    .color-text {
      background: #f5eff9;
      padding: 6px 14px;
      border-radius: 40px;
      font-size: 0.8rem;
    }

    input[type="range"] {
      width: 100%;
      margin: 8px 0;
      accent-color: #8367a5;
    }
    .slider-row {
      display: flex;
      justify-content: space-between;
      font-size: 0.75rem;
      margin-top: 4px;
    }
    .value-badge {
      background: #f0e8f5;
      padding: 2px 10px;
      border-radius: 20px;
      font-size: 0.7rem;
    }

    .file-area {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      margin: 8px 0;
    }
    .btn-sm {
      background: #efe5f6;
      border: none;
      padding: 8px 16px;
      border-radius: 40px;
      font-size: 0.8rem;
      font-weight: 500;
      cursor: pointer;
      transition: 0.1s;
    }
    .btn-sm.primary {
      background: #683c8a;
      color: white;
    }
    .btn-sm.primary:hover {
      background: #4e2b6b;
    }
    .btn-sm:hover {
      background: #e3d5ed;
    }

    .text-style-row {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      align-items: center;
      margin-top: 8px;
    }
    .text-style-row input[type="color"] {
      width: 44px;
      height: 40px;
    }
    .download-btn {
      width: 100%;
      background: #2c1f3a;
      border: none;
      padding: 12px;
      border-radius: 60px;
      font-weight: 600;
      color: white;
      font-size: 0.9rem;
      cursor: pointer;
      margin-top: 1.2rem;
      transition: 0.1s;
    }
    .download-btn:hover {
      background: #1e142b;
    }
    hr {
      margin: 1rem 0;
      border-color: #ece2f0;
    }
    .info-note {
      font-size: 0.7rem;
      color: #7c6890;
      text-align: center;
      margin-top: 0.8rem;
    }
    @media (max-width: 780px) {
      .main-grid { padding: 1.2rem; gap: 1.2rem; }
      .header { padding: 1rem 1.2rem; }
    }
  </style>
</head>
<body>
<div class="app">
  <div class="header">
    <div>
      <h1> TOTE BAG DESIGN</h1>
      <div class="sub">design your reusable tote – color · artwork · text</div>
    </div>
    <div class="store-badge">Eira store</div>
  </div>

  <div class="main-grid">
    <!-- canvas preview -->
    <div class="preview">
      <div class="preview-label">live preview</div>
      <canvas id="toteCanvas" width="500" height="500" style="width:100%; height:auto; max-width:500px; aspect-ratio:1/1"></canvas>
      <div class="info-note" style="margin-top: 12px;">move image & text with sliders – fits bag front</div>
    </div>

    <!-- controls -->
    <div class="controls">
      <!-- bag color -->
      <div class="control-block">
        <div class="control-label"><i class="fa-solid fa-bag-shopping" style="color: hsl(267, 32%, 35%);"></i> bag color</div>
        <div class="color-row">
          <input type="color" id="bagColor" value="#F5EFE6">
          <span id="colorName" class="color-text">natural linen</span>
        </div>
      </div>

      <!-- image upload + scale + vertical/horizontal -->
      <div class="control-block">
        <div class="control-label"><i class="fa-solid fa-image" style="color: hsl(267, 32%, 35%);"></i> image / artwork</div>
        <div class="file-area">
          <input type="file" id="imageUpload" accept="image/png, image/jpeg, image/webp" style="display: none;">
          <button class="btn-sm primary" id="uploadBtn">upload image</button>
          <button class="btn-sm" id="removeImgBtn">remove</button>
        </div>
        <div style="margin-top: 12px;">
          <div style="display: flex; justify-content: space-between;">
            <span><i class="fa-solid fa-expand" style="color: hsl(267, 32%, 35%);"></i> scale</span>
            <span id="scaleVal" class="value-badge">1.0</span>
          </div>
          <input type="range" id="imgScale" min="0.3" max="1.5" step="0.01" value="0.9">
        </div>
        <div style="margin-top: 8px;">
          <div style="display: flex; justify-content: space-between;">
            <span><i class="fa-solid fa-arrow-up" style="color: hsl(267, 32%, 35%);"></i> vertical position <i class="fa-solid fa-arrow-down-long" style="color: hsl(267, 32%, 35%);"></i></span>
            <span id="imgYVal" class="value-badge">0</span>
          </div>
          <input type="range" id="imgYOffset" min="-60" max="60" step="2" value="0">
        </div>
        <div style="margin-top: 8px;">
          <div style="display: flex; justify-content: space-between;">
            <span><i class="fa-solid fa-arrow-left" style="color: hsl(267, 32%, 35%);"></i> horizontal position <i class="fa-solid fa-arrow-right" style="color: hsl(267, 32%, 35%);"></i></span>
            <span id="imgXVal" class="value-badge">0</span>
          </div>
          <input type="range" id="imgXOffset" min="-55" max="55" step="2" value="0">
        </div>
      </div>

      <!-- text on bag -->
      <div class="control-block">
        <div class="control-label"><i class="fa-solid fa-pencil" style="color: hsl(267, 32%, 35%);"></i> message</div>
        <input type="text" id="bagText" value="your* DESIGN here" style="width:100%; padding: 10px; border-radius: 60px; border:1px solid #ddd2e4; margin-bottom: 10px;">
        
        <div class="text-style-row">
          <input type="color" id="textColor" value="#2E1D42">
          <input type="range" id="textSize" min="18" max="58" step="1" value="32" style="flex:1">
          <span id="sizeVal" class="value-badge">32px</span>
        </div>
        <div style="margin-top: 8px; display: flex; align-items: center; gap: 16px;">
          <label style="display: flex; gap: 6px; font-size:0.8rem;">
            <input type="checkbox" id="boldText"> bold
          </label>
        </div>
        <div style="margin-top: 12px;">
          <div style="display: flex; justify-content: space-between;">
            <span><i class="fa-solid fa-arrow-up" style="color: hsl(267, 32%, 35%);"></i> text vertical <i class="fa-solid fa-arrow-down-long" style="color: hsl(267, 32%, 35%);"></i></span>
            <span id="textYVal" class="value-badge">0</span>
          </div>
          <input type="range" id="textYOffset" min="-65" max="65" step="2" value="0">
        </div>
        <div style="margin-top: 8px;">
          <div style="display: flex; justify-content: space-between;">
            <span><i class="fa-solid fa-arrow-left" style="color: hsl(267, 32%, 35%);"></i> text horizontal<i class="fa-solid fa-arrow-right" style="color: hsl(267, 32%, 35%);"></i></span>
            <span id="textXVal" class="value-badge">0</span>
          </div>
          <input type="range" id="textXOffset" min="-60" max="60" step="2" value="0">
        </div>
      </div>

      <hr />
      <button class="download-btn" id="downloadBtn"><i class="fa-solid fa-bookmark" style="color: hsl(0, 0%, 100%);"></i> save tote bag as PNG</button>
      <div class="info-note"><i class="fa-solid fa-lightbulb" style="color:  hsl(267, 32%, 35%);"></i> Tip: Use PNG with transparency for best results</div>
    </div>
    </div>
  </div>
</div>

<script>
  (function(){
    const canvas = document.getElementById('toteCanvas');
    const ctx = canvas.getContext('2d');
    
    // tote bag geometry – classic rectangular with straps
    const bag = {
      bodyX: 100,
      bodyY: 120,
      bodyW: 300,
      bodyH: 320,
      strapLeftX: 115,
      strapRightX: 345,
      strapTopY: 75,
      strapBottomY: 120,
      strapWidth: 22
    };
    
    // DOM elements
    const bagColorPicker = document.getElementById('bagColor');
    const colorNameSpan = document.getElementById('colorName');
    const imageUpload = document.getElementById('imageUpload');
    const uploadBtn = document.getElementById('uploadBtn');
    const removeImgBtn = document.getElementById('removeImgBtn');
    const imgScaleSlider = document.getElementById('imgScale');
    const scaleValSpan = document.getElementById('scaleVal');
    const imgYOffsetSlider = document.getElementById('imgYOffset');
    const imgYValSpan = document.getElementById('imgYVal');
    const imgXOffsetSlider = document.getElementById('imgXOffset');
    const imgXValSpan = document.getElementById('imgXVal');
    const bagTextInput = document.getElementById('bagText');
    const textColorPicker = document.getElementById('textColor');
    const textSizeSlider = document.getElementById('textSize');
    const sizeValSpan = document.getElementById('sizeVal');
    const boldCheck = document.getElementById('boldText');
    const textYOffsetSlider = document.getElementById('textYOffset');
    const textYValSpan = document.getElementById('textYVal');
    const textXOffsetSlider = document.getElementById('textXOffset');
    const textXValSpan = document.getElementById('textXVal');
    const downloadBtn = document.getElementById('downloadBtn');
    
    // state
    let bagColor = '#F5EFE6';
    let userImage = null;
    let imgScale = 0.9;
    let imgOffsetY = 0;
    let imgOffsetX = 0;
    let bagText = "your* DESIGN here";
    let textColor = "#2E1D42";
    let textFontSize = 32;
    let textBold = false;
    let textOffsetY = 0;
    let textOffsetX = 0;
    
    // helper: draw tote bag shape (clean, minimal)
    function drawToteBag(color) {
      const { bodyX, bodyY, bodyW, bodyH, strapLeftX, strapRightX, strapTopY, strapBottomY, strapWidth } = bag;
      
      // left strap
      ctx.beginPath();
      ctx.moveTo(strapLeftX, strapTopY);
      ctx.lineTo(strapLeftX + strapWidth, strapTopY);
      ctx.lineTo(strapLeftX + strapWidth - 4, strapBottomY);
      ctx.lineTo(strapLeftX - 4, strapBottomY);
      ctx.fillStyle = color;
      ctx.fill();
      ctx.strokeStyle = "#cdbcdf";
      ctx.lineWidth = 1;
      ctx.stroke();
      
      // right strap
      ctx.beginPath();
      ctx.moveTo(strapRightX, strapTopY);
      ctx.lineTo(strapRightX + strapWidth, strapTopY);
      ctx.lineTo(strapRightX + strapWidth - 4, strapBottomY);
      ctx.lineTo(strapRightX - 4, strapBottomY);
      ctx.fill();
      ctx.stroke();
      
      // main body (rounded rectangle)
      const radius = 20;
      ctx.beginPath();
      ctx.moveTo(bodyX + radius, bodyY);
      ctx.lineTo(bodyX + bodyW - radius, bodyY);
      ctx.quadraticCurveTo(bodyX + bodyW, bodyY, bodyX + bodyW, bodyY + radius);
      ctx.lineTo(bodyX + bodyW, bodyY + bodyH - radius);
      ctx.quadraticCurveTo(bodyX + bodyW, bodyY + bodyH, bodyX + bodyW - radius, bodyY + bodyH);
      ctx.lineTo(bodyX + radius, bodyY + bodyH);
      ctx.quadraticCurveTo(bodyX, bodyY + bodyH, bodyX, bodyY + bodyH - radius);
      ctx.lineTo(bodyX, bodyY + radius);
      ctx.quadraticCurveTo(bodyX, bodyY, bodyX + radius, bodyY);
      ctx.closePath();
      ctx.fillStyle = color;
      ctx.fill();
      ctx.strokeStyle = "#cfc1e0";
      ctx.stroke();
      
      // subtle fold line (bottom crease)
      ctx.beginPath();
      ctx.moveTo(bodyX + 15, bodyY + bodyH - 18);
      ctx.lineTo(bodyX + bodyW - 15, bodyY + bodyH - 18);
      ctx.lineWidth = 1.2;
      ctx.strokeStyle = "#cfbfdb";
      ctx.stroke();
      
      // small stitch detail (dashed effect)
      ctx.beginPath();
      ctx.setLineDash([4, 6]);
      ctx.moveTo(bodyX + 12, bodyY + 12);
      ctx.lineTo(bodyX + bodyW - 12, bodyY + 12);
      ctx.strokeStyle = "#c4b2d6";
      ctx.stroke();
      ctx.setLineDash([]);
    }
    
    // draw image clipped to bag front
    function drawClippedImage() {
      if (!userImage) return;
      const { bodyX, bodyY, bodyW, bodyH } = bag;
      const maxW = bodyW * 0.72;
      const maxH = bodyH * 0.58;
      let drawW = maxW;
      let drawH = (drawW / userImage.width) * userImage.height;
      if (drawH > maxH) {
        drawH = maxH;
        drawW = (drawH / userImage.height) * userImage.width;
      }
      drawW *= imgScale;
      drawH *= imgScale;
      
      let baseX = bodyX + (bodyW/2) - (drawW/2) + imgOffsetX;
      let baseY = bodyY + (bodyH * 0.4) - (drawH/2) + imgOffsetY;
      ctx.drawImage(userImage, baseX, baseY, drawW, drawH);
    }
    
    // text wrapping
    function wrapText(ctx, text, maxWidth) {
      const words = text.split(' ');
      const lines = [];
      let current = '';
      for (let w of words) {
        let test = current ? current + ' ' + w : w;
        let metrics = ctx.measureText(test);
        if (metrics.width > maxWidth && current.length > 0) {
          lines.push(current);
          current = w;
        } else {
          current = test;
        }
      }
      if (current) lines.push(current);
      return lines;
    }
    
    function drawClippedText() {
      if (!bagText.trim()) return;
      const { bodyX, bodyY, bodyW, bodyH } = bag;
      ctx.save();
      const fontWeight = textBold ? 'bold ' : '';
      ctx.font = `${fontWeight}${textFontSize}px system-ui, "Segoe UI", -apple-system`;
      ctx.fillStyle = textColor;
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      
      const maxTextWidth = bodyW * 0.78;
      const lines = wrapText(ctx, bagText.trim(), maxTextWidth);
      const lineHeight = textFontSize * 1.2;
      const totalH = lines.length * lineHeight;
      
      let baseY = bodyY + (bodyH * 0.66) + textOffsetY;
      let baseX = bodyX + (bodyW/2) + textOffsetX;
      const startY = baseY - (totalH/2);
      
      for (let i=0; i<lines.length; i++) {
        ctx.fillText(lines[i], baseX, startY + i*lineHeight + lineHeight/2);
      }
      ctx.restore();
    }
    
    // main render
    function render() {
      canvas.width = 500;
      canvas.height = 500;
      ctx.clearRect(0, 0, 500, 500);
      ctx.fillStyle = "rgba(236, 227, 239, 0.5)";
      ctx.fillRect(0, 0, 500, 500);
      
      // soft shadow for bag
      ctx.shadowColor = "rgba(0,0,0,0.08)";
      ctx.shadowBlur = 10;
      ctx.shadowOffsetX = 3;
      ctx.shadowOffsetY = 5;
      drawToteBag(bagColor);
      ctx.shadowColor = "transparent";
      
      // clip to bag body for decorations
      ctx.save();
      const { bodyX, bodyY, bodyW, bodyH } = bag;
      ctx.beginPath();
      ctx.roundRect(bodyX, bodyY, bodyW, bodyH, 20);
      ctx.clip();
      
      drawClippedImage();
      drawClippedText();
      
      ctx.restore();
      
      // small highlight on top edge
      ctx.beginPath();
      ctx.moveTo(bodyX + 14, bodyY + 3);
      ctx.lineTo(bodyX + bodyW - 14, bodyY + 3);
      ctx.lineWidth = 2;
      ctx.strokeStyle = "rgba(255,250,235,0.5)";
      ctx.stroke();
    }
    
    // helper for roundRect
    if (!CanvasRenderingContext2D.prototype.roundRect) {
      CanvasRenderingContext2D.prototype.roundRect = function(x, y, w, h, r) {
        if (w < 2 * r) r = w / 2;
        if (h < 2 * r) r = h / 2;
        this.moveTo(x+r, y);
        this.lineTo(x+w-r, y);
        this.quadraticCurveTo(x+w, y, x+w, y+r);
        this.lineTo(x+w, y+h-r);
        this.quadraticCurveTo(x+w, y+h, x+w-r, y+h);
        this.lineTo(x+r, y+h);
        this.quadraticCurveTo(x, y+h, x, y+h-r);
        this.lineTo(x, y+r);
        this.quadraticCurveTo(x, y, x+r, y);
        return this;
      };
    }
    
    function update() { render(); }
    
    // image handling
    function loadImage(file) {
      if (!file) return;
      const reader = new FileReader();
      reader.onload = (e) => {
        const img = new Image();
        img.onload = () => {
          userImage = img;
          update();
        };
        img.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
    
    function removeImage() {
      userImage = null;
      imageUpload.value = '';
      update();
    }
    
    // event listeners
    bagColorPicker.addEventListener('input', (e) => {
      bagColor = e.target.value;
      let friendly = "custom";
      if (bagColor === '#F5EFE6') friendly = "natural linen";
      else if (bagColor === '#FFFFFF') friendly = "pure white";
      else if (bagColor === '#D9C8B3') friendly = "warm beige";
      else if (bagColor === '#B7D0E5') friendly = "dusty blue";
      colorNameSpan.innerText = friendly;
      update();
    });
    
    uploadBtn.addEventListener('click', () => imageUpload.click());
    imageUpload.addEventListener('change', (e) => {
      if (e.target.files && e.target.files[0]) loadImage(e.target.files[0]);
    });
    removeImgBtn.addEventListener('click', removeImage);
    
    imgScaleSlider.addEventListener('input', (e) => {
      imgScale = parseFloat(e.target.value);
      scaleValSpan.innerText = imgScale.toFixed(2);
      update();
    });
    imgYOffsetSlider.addEventListener('input', (e) => {
      imgOffsetY = parseInt(e.target.value);
      imgYValSpan.innerText = imgOffsetY;
      update();
    });
    imgXOffsetSlider.addEventListener('input', (e) => {
      imgOffsetX = parseInt(e.target.value);
      imgXValSpan.innerText = imgOffsetX;
      update();
    });
    bagTextInput.addEventListener('input', (e) => {
      bagText = e.target.value;
      update();
    });
    textColorPicker.addEventListener('input', (e) => {
      textColor = e.target.value;
      update();
    });
    textSizeSlider.addEventListener('input', (e) => {
      textFontSize = parseInt(e.target.value);
      sizeValSpan.innerText = textFontSize + 'px';
      update();
    });
    boldCheck.addEventListener('change', (e) => {
      textBold = e.target.checked;
      update();
    });
    textYOffsetSlider.addEventListener('input', (e) => {
      textOffsetY = parseInt(e.target.value);
      textYValSpan.innerText = textOffsetY;
      update();
    });
    textXOffsetSlider.addEventListener('input', (e) => {
      textOffsetX = parseInt(e.target.value);
      textXValSpan.innerText = textOffsetX;
      update();
    });
    
    downloadBtn.addEventListener('click', () => {
      const link = document.createElement('a');
      link.download = 'eira_tote_bag.png';
      link.href = canvas.toDataURL('image/png');
      link.click();
    });
    
    // initial values
    function init() {
      bagColor = '#F5EFE6';
      bagColorPicker.value = bagColor;
      colorNameSpan.innerText = "natural linen";
      bagText = "your* DESIGN here";
      bagTextInput.value = bagText;
      textColor = "#2E1D42";
      textColorPicker.value = textColor;
      textFontSize = 32;
      textSizeSlider.value = 32;
      sizeValSpan.innerText = "32px";
      textBold = false;
      boldCheck.checked = false;
      imgScale = 0.9;
      imgScaleSlider.value = "0.9";
      scaleValSpan.innerText = "0.90";
      imgOffsetY = 0;
      imgYOffsetSlider.value = "0";
      imgYValSpan.innerText = "0";
      imgOffsetX = 0;
      imgXOffsetSlider.value = "0";
      imgXValSpan.innerText = "0";
      textOffsetY = 0;
      textYOffsetSlider.value = "0";
      textYValSpan.innerText = "0";
      textOffsetX = 0;
      textXOffsetSlider.value = "0";
      textXValSpan.innerText = "0";
      userImage = null;
      update();
    }
    init();
  })();
</script>
<script scr="script.js"></script>
</body>
</html>