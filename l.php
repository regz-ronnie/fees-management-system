<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Website with Logo</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Arial', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f0f0f0;
    }

    #logocard {
      width: 300px;
      height: 200px;
      background-color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      border: 5px solid transparent;
      border-radius: 20px;
      padding: 20px;
      animation: borderColorChange 5s infinite alternate;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    #logo {
      width: 80%;
      height: auto;
    }

    @keyframes borderColorChange {
      0% { border-color: #ff4b5c; }
      25% { border-color: #4bff7b; }
      50% { border-color: #4b8fff; }
      75% { border-color: #ffdb3f; }
      100% { border-color: #ff4b5c; }
    }

    #logo-container {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 1000;
      text-align: center;
    }

    #logo-circle {
      display: inline-block;
      width: 240px;
      height: 240px;
      border-radius: 50%;
      border: 5px solid #333;
      padding: 20px;
      background-color: gold;
      box-sizing: border-box;
      position: relative;
    }

    #logo-circle img {
      border-radius: 50%;
      width: 100%;
      height: auto;
    }

    #logo-text {
      position: absolute;
      bottom: 10px;
      left: 50%;
      transform: translateX(-50%);
      font-family: Arial, sans-serif;
      font-size: 18px;
      font-weight: bold;
      color: #333;
      letter-spacing: 1px;
    }

    .loading-dots {
      font-size: 24px;
      margin-top: 20px;
      color: #333;
    }

    .dot {
      display: inline-block;
      width: 10px;
      height: 10px;
      margin: 0 5px;
      border-radius: 50%;
      background-color: #333;
      animation: bounce 1s infinite;
    }

    .dot:nth-child(2) {
      animation-delay: 0.2s;
    }

    .dot:nth-child(3) {
      animation-delay: 0.4s;
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    #content {
      display: none;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }
    
    #content.show {
      display: block;
      opacity: 1;
    }
  </style>
</head>
<body>
  <div class="logocard">
    <div id="logo-container">
      <div id="logo-circle">
        <img src="logo.jpg" alt="OBEYIA Company Logo" id="logo" />
        <div id="logo-text">OBEYIA</div>
      </div>
      <div class="loading-dots">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
      </div>
    </div>
  </div>

  <div id="content">
    <h1>Welcome to My Website</h1>
  </div>

  <script>
    window.onload = function() {
      const logoContainer = document.getElementById('logo-container');
      const content = document.getElementById('content');

      setTimeout(function() {
        logoContainer.style.opacity = '0';
        setTimeout(function() {
          logoContainer.style.display = 'none';
          content.classList.add('show');
        }, 1000);
      }, 3000);
    };
  </script>
</body>
</html>
