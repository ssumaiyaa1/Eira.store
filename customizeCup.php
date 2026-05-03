<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <title>Eira store | Custom Mug Studio</title>
   <script src="https://kit.fontawesome.com/d5f0c685f3.js" crossorigin="anonymous"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: rgba(236, 227, 239, 0.996);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
      padding: 2rem 1.5rem;
    }

    .customizer-container {
      max-width: 1400px;
      width: 100%;
      background: rgba(255, 255, 255, 0.94);
      backdrop-filter: blur(2px);
      border-radius: 2.5rem;
      box-shadow: 0 30px 50px -20px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255,255,240,0.3);
      overflow: hidden;
    }

    .brand-header {
      padding: 1.4rem 2.4rem 0.8rem 2.4rem;
      border-bottom: 2px solid rgba(160, 130, 170, 0.25);
      background: rgba(255, 250, 245, 0.7);
      display: flex;
      justify-content: space-between;
      align-items: baseline;
      flex-wrap: wrap;
    }
    .brand-header h1 {
      font-size: 1.9rem;
      font-weight: 700;
      background: linear-gradient(135deg, #4A2C5F, #8460A8);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    .store-name {
      font-size: 1rem;
      font-weight: 600;
      background: #F1E7F5;
      padding: 6px 16px;
      border-radius: 40px;
      color: #4e2b63;
    }
    .brand-header p {
      color: #4e3a5e;
      font-weight: 500;
      margin-top: 0.3rem;
      font-size: 0.9rem;
      width: 100%;
    }

    .customizer-layout {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      padding: 2rem 2.4rem 2.4rem 2.4rem;
    }

    .preview-panel {
      flex: 1.2;
      min-width: 300px;
      background: #FEFCF8;
      border-radius: 2rem;
      box-shadow: 0 18px 30px rgba(0, 0, 0, 0.1);
      padding: 1.5rem;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .mockup-title {
      font-weight: 600;
      color: #3a2a48;
      margin-bottom: 1rem;
      font-size: 1.2rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .mockup-title span {
      background: #EFE4F5;
      padding: 4px 14px;
      border-radius: 40px;
      font-size: 0.7rem;
      font-weight: 500;
    }
    canvas {
      display: block;
      margin: 0 auto;
      width: 100%;
      height: auto;
      max-width: 550px;
      border-radius: 28px;
      box-shadow: 0 20px 35px -8px rgba(0, 0, 0, 0.25);
      background: #F9F3F9;
      cursor: pointer;
    }

    .controls-panel {
      flex: 0.9;
      min-width: 280px;
      background: #fffffffb;
      border-radius: 2rem;
      padding: 1.6rem 1.8rem;
      box-shadow: 0 8px 22px rgba(0, 0, 0, 0.05);
    }

    .control-group {
      margin-bottom: 1.7rem;
      border-bottom: 1px solid #ede4f2;
      padding-bottom: 1.2rem;
    }
    .control-group label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      color: #2d233b;
      margin-bottom: 12px;
      font-size: 0.9rem;
    }
    input, select {
      width: 100%;
      padding: 10px 12px;
      border-radius: 60px;
      border: 1.5px solid #e2d4ea;
      background: white;
      font-family: inherit;
      font-size: 0.9rem;
    }
    .color-row {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .color-row input[type="color"] {
      width: 58px;
      height: 48px;
      border-radius: 30px;
      border: 2px solid #cfbfdf;
    }
    .image-upload-area {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      align-items: center;
    }
    .file-label {
      background: #683c8a;
      color: white;
      padding: 8px 18px;
      border-radius: 40px;
      font-size: 0.8rem;
      font-weight: 500;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      border: none;
    }
    .file-label:hover { background: #4a2b66; }
    .remove-img-btn {
      background: #efe5f6;
      border: none;
      padding: 8px 18px;
      border-radius: 40px;
      cursor: pointer;
    }
    .slider-value {
      background: #ede2f5;
      padding: 4px 12px;
      border-radius: 30px;
      font-size: 0.75rem;
      font-weight: 600;
      margin-left: 10px;
    }
    input[type="range"] {
      padding: 0;
      height: 5px;
      accent-color: #7b52a2;
    }
    .text-styling {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      align-items: center;
    }
    button.download-btn {
      width: 100%;
      background: #553c74;
      border: none;
      padding: 14px;
      border-radius: 50px;
      font-weight: 700;
      color: white;
      font-size: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      cursor: pointer;
      margin-top: 1rem;
    }
    .info-note {
      font-size: 0.7rem;
      text-align: center;
      margin-top: 1rem;
      color: #6d5a7c;
    }
    hr { margin: 12px 0; border-color: #eadaf0; }
    @media (max-width: 780px) {
      .customizer-layout { padding: 1.5rem; gap: 1.2rem; }
      .brand-header h1 { font-size: 1.5rem; }
    }
  </style>
</head>
<body>
<div class="customizer-container">
  <div class="brand-header">
    <div>
      <h1>CUP DESIGNER</h1>
      <p>Personalize every sip — color, art, text. Your vision on ceramic.</p>
    </div>
    <div class="store-name">Eira store</div>
  </div>
  <div class="customizer-layout">
    <div class="preview-panel">
      <div class="mockup-title">
        <i class="fa-solid fa-mug-saucer" style="color: #553c74;"></i> Your Custom Mug
        <span>live 3D style</span>
      </div>
      <canvas id="mugCanvas" width="600" height="600" style="width:100%; height:auto; max-width:600px; aspect-ratio:1/1"></canvas>
      <div class="info-note">⚡ Real-time • Use sliders to move image & text up/down</div>
    </div>

    <div class="controls-panel">
      <!-- Mug Color -->
      <div class="control-group">
        <label><i class="fa-solid fa-mug-saucer" style="color: #553c74;"></i> Mug Color (ceramic glaze)</label>
        <div class="color-row">
          <input type="color" id="mugColorPicker" value="#F8F3F0">
          <span id="colorValueDisplay">Warm White</span>
        </div>
      </div>

      <!-- Image Upload + Scale + Vertical Offset -->
      <div class="control-group">
        <label><i class="fa-solid fa-image" style="color: hsl(267, 32%, 35%);"></i> Picture / Artwork (center front)</label>
        <div class="image-upload-area">
          <input type="file" id="imageUpload" accept="image/jpeg, image/png, image/webp" style="display: none;">
          <button class="file-label" id="uploadBtn"><i class="fa-solid fa-upload" style="color: hsl(267, 32%, 35%);"></i> Upload Image</button>
          <button class="remove-img-btn" id="removeImageBtn">✖ Remove</button>
        </div>
        <div style="margin-top: 10px;">
          <label><i class="fa-solid fa-expand" style="color: hsl(267, 32%, 35%);"></i> Image scale <span id="scaleValueDisplay" class="slider-value">1.0</span></label>
          <input type="range" id="imageScaleSlider" min="0.45" max="1.7" step="0.01" value="1.0">
        </div>
        <div style="margin-top: 10px;">
          <label><i class="fa-solid fa-arrow-up" style="color: hsl(267, 32%, 35%);"></i><i class="fa-solid fa-arrow-down-long" style="color: hsl(267, 32%, 35%);"></i> Image Vertical Offset <span id="imgOffsetDisplay" class="slider-value">0</span></label>
          <input type="range" id="imageYOffsetSlider" min="-55" max="55" step="2" value="0">
          <div class="info-note">move up / down on mug surface</div>
        </div>
      </div>

      <!-- Custom Text + Vertical Offset -->
      <div class="control-group">
        <label><i class="fa-solid fa-pencil" style="color: hsl(267, 32%, 35%);"></i> Message on Mug</label>
        <input type="text" id="customTextInput" placeholder="Your message ..." value="your* DESIGN here">
        <div class="text-styling" style="margin-top: 12px;">
          <input type="color" id="textColorPicker" value="#2E1D42">
          <input type="range" id="fontSizeSlider" min="18" max="64" step="1" value="34">
          <span id="fontSizeValue" class="slider-value">34px</span>
        </div>
        <div style="margin-top: 8px;">
          <label><i class="fa-solid fa-bold" style="color: hsl(267, 32%, 35%);"></i> Bold text</label>
          <input type="checkbox" id="boldTextToggle" style="width: 18px; margin-left: 12px;">
        </div>
        <div style="margin-top: 12px;">
          <label><i class="fa-solid fa-arrow-up" style="color: hsl(267, 32%, 35%);"></i><i class="fa-solid fa-arrow-down-long" style="color: hsl(267, 32%, 35%);"></i> Text Vertical Offset <span id="textOffsetDisplay" class="slider-value">0</span></label>
          <input type="range" id="textYOffsetSlider" min="-60" max="65" step="2" value="0">
          <div class="info-note">fine-tune text position independently</div>
        </div>
      </div>

      <hr>
      <button class="download-btn" id="downloadMugBtn"><i class="fa-solid fa-bookmark" style="color: hsl(0, 0%, 100%);"></i> SAVE MUG DESIGN (PNG)</button>
      <div class="info-note"><i class="fa-solid fa-lightbulb" style="color: hsl(267, 32%, 35%);"></i> Tip: Use PNG with transparency for best results</div>
    </div>
  </div>
</div>

<script>
  (function() {
    const canvas = document.getElementById('mugCanvas');
    const ctx = canvas.getContext('2d');
    
    // Mug geometry (natural ceramic shape)
    const mugGeom = {
      leftX: 160,
      topY: 150,
      width: 280,
      height: 310
    };
    
    // DOM elements
    const mugColorPicker = document.getElementById('mugColorPicker');
    const colorValueDisplay = document.getElementById('colorValueDisplay');
    const imageUploadInput = document.getElementById('imageUpload');
    const uploadBtn = document.getElementById('uploadBtn');
    const removeImageBtn = document.getElementById('removeImageBtn');
    const imageScaleSlider = document.getElementById('imageScaleSlider');
    const scaleValueDisplay = document.getElementById('scaleValueDisplay');
    const imageYOffsetSlider = document.getElementById('imageYOffsetSlider');
    const imgOffsetDisplay = document.getElementById('imgOffsetDisplay');
    const customTextInput = document.getElementById('customTextInput');
    const textColorPicker = document.getElementById('textColorPicker');
    const fontSizeSlider = document.getElementById('fontSizeSlider');
    const fontSizeValue = document.getElementById('fontSizeValue');
    const boldTextToggle = document.getElementById('boldTextToggle');
    const textYOffsetSlider = document.getElementById('textYOffsetSlider');
    const textOffsetDisplay = document.getElementById('textOffsetDisplay');
    const downloadBtn = document.getElementById('downloadMugBtn');
    
    // State
    let mugColor = '#F8F3F0';
    let userImage = null;
    let imageScale = 1.0;
    let imageYOffset = 0;       // pixels vertical shift (negative = up, positive = down)
    let currentText = "your* DESIGN here";
    let textColor = "#2E1D42";
    let fontSize = 34;
    let isBold = false;
    let textYOffset = 0;         // vertical shift for text
    
    // Helper: draw rounded body
    function drawMugBody(ctx, x, y, w, h, color) {
      const radius = 28;
      ctx.beginPath();
      ctx.moveTo(x + radius, y);
      ctx.lineTo(x + w - radius, y);
      ctx.quadraticCurveTo(x + w, y, x + w, y + radius);
      ctx.lineTo(x + w, y + h - radius);
      ctx.quadraticCurveTo(x + w, y + h, x + w - radius, y + h);
      ctx.lineTo(x + radius, y + h);
      ctx.quadraticCurveTo(x, y + h, x, y + h - radius);
      ctx.lineTo(x, y + radius);
      ctx.quadraticCurveTo(x, y, x + radius, y);
      ctx.closePath();
      ctx.fillStyle = color;
      ctx.fill();
      // subtle inner shading
      ctx.beginPath();
      ctx.moveTo(x + 12, y + 12);
      ctx.lineTo(x + w - 12, y + 12);
      ctx.lineTo(x + w - 8, y + h - 12);
      ctx.lineTo(x + 8, y + h - 12);
      ctx.fillStyle = 'rgba(255,255,240,0.12)';
      ctx.fill();
    }
    
    function drawMugHandle(ctx, color, x, y, w, h) {
      const startX = x + w;
      const startY = y + 45;
      const endX = x + w - 12;
      const endY = y + h - 55;
      ctx.save();
      ctx.beginPath();
      ctx.moveTo(startX, startY);
      ctx.quadraticCurveTo(startX + 40, startY + 15, startX + 32, startY + 55);
      ctx.quadraticCurveTo(startX + 28, startY + 100, endX + 15, endY + 12);
      ctx.lineTo(endX + 4, endY);
      ctx.quadraticCurveTo(startX + 18, startY + 95, startX, startY + 35);
      ctx.fillStyle = color;
      ctx.fill();
      ctx.beginPath();
      ctx.moveTo(startX - 3, startY + 10);
      ctx.quadraticCurveTo(startX + 32, startY + 22, startX + 20, startY + 65);
      ctx.lineWidth = 2.2;
      ctx.strokeStyle = '#aa9bbc';
      ctx.stroke();
      ctx.restore();
    }
    
    function drawTopRim(ctx, color, x, y, w) {
      ctx.save();
      ctx.shadowBlur = 4;
      ctx.shadowColor = "rgba(0,0,0,0.1)";
      ctx.beginPath();
      ctx.ellipse(x + w/2, y - 10, w/2, 16, 0, 0, Math.PI * 2);
      ctx.fillStyle = color;
      ctx.fill();
      ctx.beginPath();
      ctx.ellipse(x + w/2, y - 10, w/2 - 12, 10, 0, 0, Math.PI * 2);
      ctx.fillStyle = "#FFF9F0";
      ctx.fill();
      ctx.restore();
    }
    
    function addReflection(ctx, x, y, w, h) {
      ctx.save();
      ctx.globalAlpha = 0.2;
      ctx.beginPath();
      ctx.moveTo(x + 12, y + 18);
      ctx.lineTo(x + 30, y + 20);
      ctx.lineTo(x + 26, y + h - 40);
      ctx.lineTo(x + 8, y + h - 42);
      ctx.fillStyle = "#FFFFFF";
      ctx.fill();
      ctx.restore();
    }
    
    function drawMugShadow(ctx, x, y, w, h) {
      ctx.beginPath();
      ctx.ellipse(x + w/2, y + h - 4, w/2.5, 12, 0, 0, Math.PI * 2);
      ctx.fillStyle = "rgba(0,0,0,0.12)";
      ctx.fill();
    }
    
    // text wrapping
    function wrapTextLines(ctx, text, maxWidth) {
      const words = text.split(' ');
      const lines = [];
      let currentLine = '';
      for (let i = 0; i < words.length; i++) {
        const testLine = currentLine + (currentLine ? ' ' : '') + words[i];
        const metrics = ctx.measureText(testLine);
        if (metrics.width > maxWidth && currentLine.length > 0) {
          lines.push(currentLine);
          currentLine = words[i];
        } else {
          currentLine = testLine;
        }
      }
      if (currentLine) lines.push(currentLine);
      return lines;
    }
    
    // Create clipping path for mug interior
    function clipToMug(ctx, x, y, w, h) {
      const rad = 26;
      ctx.beginPath();
      ctx.moveTo(x + rad, y);
      ctx.lineTo(x + w - rad, y);
      ctx.quadraticCurveTo(x + w, y, x + w, y + rad);
      ctx.lineTo(x + w, y + h - rad);
      ctx.quadraticCurveTo(x + w, y + h, x + w - rad, y + h);
      ctx.lineTo(x + rad, y + h);
      ctx.quadraticCurveTo(x, y + h, x, y + h - rad);
      ctx.lineTo(x, y + rad);
      ctx.quadraticCurveTo(x, y, x + rad, y);
      ctx.closePath();
      ctx.clip();
    }
    
    // Main render
    function renderMug() {
      canvas.width = 600;
      canvas.height = 600;
      ctx.clearRect(0, 0, 600, 600);
      ctx.fillStyle = "rgba(236, 227, 239, 0.6)";
      ctx.fillRect(0, 0, 600, 600);
      
      // shadow for whole mug
      ctx.shadowColor = "rgba(0,0,0,0.2)";
      ctx.shadowBlur = 14;
      ctx.shadowOffsetX = 5;
      ctx.shadowOffsetY = 7;
      
      drawMugHandle(ctx, mugColor, mugGeom.leftX, mugGeom.topY, mugGeom.width, mugGeom.height);
      drawMugBody(ctx, mugGeom.leftX, mugGeom.topY, mugGeom.width, mugGeom.height, mugColor);
      ctx.shadowColor = "transparent";
      drawTopRim(ctx, mugColor, mugGeom.leftX, mugGeom.topY, mugGeom.width);
      
      // --- Clip to mug interior ---
      ctx.save();
      clipToMug(ctx, mugGeom.leftX, mugGeom.topY, mugGeom.width, mugGeom.height);
      
      // ----- DRAW IMAGE with vertical offset -----
      if (userImage && userImage.complete && userImage.naturalWidth !== 0) {
        const imgW = userImage.width;
        const imgH = userImage.height;
        const maxWidthInside = mugGeom.width * 0.68;
        const maxHeightInside = mugGeom.height * 0.55;
        let drawWidth = maxWidthInside;
        let drawHeight = (drawWidth / imgW) * imgH;
        if (drawHeight > maxHeightInside) {
          drawHeight = maxHeightInside;
          drawWidth = (drawHeight / imgH) * imgW;
        }
        drawWidth *= imageScale;
        drawHeight *= imageScale;
        
        // default Y position (centered vertically in the upper-mid area)
        let baseImgY = mugGeom.topY + (mugGeom.height * 0.38) - (drawHeight / 2);
        // apply user vertical offset
        baseImgY += imageYOffset;
        
        const imgX = mugGeom.leftX + (mugGeom.width / 2) - (drawWidth / 2);
        ctx.drawImage(userImage, imgX, baseImgY, drawWidth, drawHeight);
      }
      
      // ----- DRAW TEXT with vertical offset -----
      if (currentText && currentText.trim() !== "") {
        ctx.save();
        const fontStyle = isBold ? "bold " : "";
        ctx.font = `${fontStyle}${fontSize}px "Inter", "Segoe UI", "Poppins", system-ui`;
        ctx.fillStyle = textColor;
        ctx.textAlign = "center";
        ctx.textBaseline = "middle";
        ctx.shadowBlur = 0;
        
        const maxTextWidth = mugGeom.width * 0.78;
        const lines = wrapTextLines(ctx, currentText.trim(), maxTextWidth);
        const lineHeight = fontSize * 1.25;
        const totalHeight = lines.length * lineHeight;
        
        // default Y: if image exists, place text lower, else centered
        let baseTextY = mugGeom.topY + (mugGeom.height * 0.66);
        if (userImage) baseTextY = mugGeom.topY + (mugGeom.height * 0.72);
        else baseTextY = mugGeom.topY + (mugGeom.height * 0.62);
        
        // add user offset
        baseTextY += textYOffset;
        
        const firstLineY = baseTextY - (totalHeight / 2);
        for (let i = 0; i < lines.length; i++) {
          ctx.fillText(lines[i], mugGeom.leftX + mugGeom.width/2, firstLineY + (i * lineHeight) + lineHeight/2);
        }
        ctx.restore();
      }
      
      ctx.restore(); // end clip
      
      // post-clip reflections and shadow
      addReflection(ctx, mugGeom.leftX, mugGeom.topY, mugGeom.width, mugGeom.height);
      drawMugShadow(ctx, mugGeom.leftX, mugGeom.topY, mugGeom.width, mugGeom.height);
      
      // extra highlight
      ctx.beginPath();
      ctx.moveTo(mugGeom.leftX + mugGeom.width - 8, mugGeom.topY + 35);
      ctx.lineTo(mugGeom.leftX + mugGeom.width - 3, mugGeom.topY + 32);
      ctx.lineTo(mugGeom.leftX + mugGeom.width - 5, mugGeom.topY + mugGeom.height - 45);
      ctx.fillStyle = "rgba(255,245,235,0.3)";
      ctx.fill();
    }
    
    function updateMug() { renderMug(); }
    
    // Image handling
    function loadImageFromFile(file) {
      if (!file) return;
      const reader = new FileReader();
      reader.onload = (e) => {
        const img = new Image();
        img.onload = () => {
          userImage = img;
          updateMug();
        };
        img.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
    
    function removeImage() {
      userImage = null;
      imageUploadInput.value = '';
      updateMug();
    }
    
    // Event listeners
    mugColorPicker.addEventListener('input', (e) => {
      mugColor = e.target.value;
      let colorName = "Custom Glaze";
      if (mugColor === '#F8F3F0') colorName = "Warm White";
      else if (mugColor === '#FFFFFF') colorName = "Pure White";
      else if (mugColor === '#D6C8E0') colorName = "Lavender Hue";
      colorValueDisplay.innerText = colorName;
      updateMug();
    });
    
    uploadBtn.addEventListener('click', () => imageUploadInput.click());
    imageUploadInput.addEventListener('change', (e) => {
      if (e.target.files && e.target.files[0]) loadImageFromFile(e.target.files[0]);
    });
    removeImageBtn.addEventListener('click', removeImage);
    
    imageScaleSlider.addEventListener('input', (e) => {
      imageScale = parseFloat(e.target.value);
      scaleValueDisplay.innerText = imageScale.toFixed(2);
      updateMug();
    });
    
    imageYOffsetSlider.addEventListener('input', (e) => {
      imageYOffset = parseInt(e.target.value);
      imgOffsetDisplay.innerText = imageYOffset;
      updateMug();
    });
    
    customTextInput.addEventListener('input', (e) => {
      currentText = e.target.value;
      updateMug();
    });
    textColorPicker.addEventListener('input', (e) => {
      textColor = e.target.value;
      updateMug();
    });
    fontSizeSlider.addEventListener('input', (e) => {
      fontSize = parseInt(e.target.value);
      fontSizeValue.innerText = fontSize + 'px';
      updateMug();
    });
    boldTextToggle.addEventListener('change', (e) => {
      isBold = e.target.checked;
      updateMug();
    });
    textYOffsetSlider.addEventListener('input', (e) => {
      textYOffset = parseInt(e.target.value);
      textOffsetDisplay.innerText = textYOffset;
      updateMug();
    });
    
    downloadBtn.addEventListener('click', () => {
      try {
        const link = document.createElement('a');
        link.download = 'eira_custom_mug.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
      } catch(err) { alert("Preview ready, PNG export works."); }
    });
    
    // Initialize defaults
    function init() {
      mugColor = '#F8F3F0';
      mugColorPicker.value = mugColor;
      colorValueDisplay.innerText = 'Warm White';
      currentText = "your* DESIGN here";
      customTextInput.value = currentText;
      textColor = "#2E1D42";
      textColorPicker.value = textColor;
      fontSize = 34;
      fontSizeSlider.value = fontSize;
      fontSizeValue.innerText = fontSize + 'px';
      isBold = false;
      boldTextToggle.checked = false;
      imageScale = 1.0;
      imageScaleSlider.value = "1.0";
      scaleValueDisplay.innerText = "1.00";
      imageYOffset = 0;
      imageYOffsetSlider.value = "0";
      imgOffsetDisplay.innerText = "0";
      textYOffset = 0;
      textYOffsetSlider.value = "0";
      textOffsetDisplay.innerText = "0";
      userImage = null;
      updateMug();
    }
    init();
  })();
</script>
<script scr="script.js"></script>
</body>
</html>