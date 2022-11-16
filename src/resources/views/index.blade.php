<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calculator</title>
    @vite('resources/css/app.css')
</head>
<body>
<div>
    <div class="grid-container">
        <div class="itemScreen black-line h60"></div>
        <div class="item2 grid-buttons-container">
            <button class="btnClear">C</button>
            <button class="btnBackSpace">B</button>

            <button class="btn7">7</button>
            <button class="btn8">8</button>
            <button class="btn9">9</button>
            <button class="btnDiv">/</button>

            <button class="btn4">4</button>
            <button class="btn5">5</button>
            <button class="btn6">6</button>
            <button class="btnMul">*</button>

            <button class="btn1">1</button>
            <button class="btn2">2</button>
            <button class="btn3">3</button>
            <button class="btnSub">-</button>

            <button class="btn0">0</button>
            <button class="btnDot">.</button>
            <button class="btnSum">+</button>
            <button class="btnCalc">=</button>
        </div>
        <div class="itemHistory">
        </div>
        <div class="itemBottom">
            <div class="error"></div>
        </div>
    </div>
</div>
@vite('resources/js/app.js')
</body>
</html>
