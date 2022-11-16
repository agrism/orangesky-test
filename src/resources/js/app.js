import './bootstrap';

document.addEventListener('readystatechange', function (event) {

    if (document.readyState === "complete") {
        let screen = '';
        let screenElement = document.querySelector('.itemScreen');
        let bottomElement = document.querySelector('.itemBottom');
        let historyElement = document.querySelector('.itemHistory');
        let isFirstNegative = false;
        let inputBuffer = '';

        let stringContainsElementCount = function (str, elements) {
            let matches = 0;
            str.split('').forEach(part => {
                if (elements.includes(part)) {
                    matches++;
                }
            })
            return matches;
        }

        let drawAlert = function (msg) {
            bottomElement.innerHTML = msg;
            setTimeout(() => bottomElement.innerHTML = '', 2000);
        }

        let keys = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '=', 'C', '/', '*', '-', '+', '.', 'B'];
        let operatorKeys = ['+', '-', '*', '/'];

        document.querySelectorAll("button").forEach(function (element) {
            element.addEventListener('click', function (event) {
                let action = event.target.innerText;

                if (!keys.includes(action)) {
                    screenElement.innerText = screen = '';
                    return;
                }

                if (action == 'B') {
                    screenElement.innerText = screen = screen.slice(0, -1);
                    return;
                }

                if (action === 'C') {
                    screenElement.innerText = screen = '';
                    return;
                }

                if (screen.length > 16) {
                    drawAlert('Input is too long!')
                    return;
                }

                let bufferScreen = screen;
                bufferScreen += action;

                if (action === '='
                    || (operatorKeys.includes(action) && (!bufferScreen.startsWith('-') && stringContainsElementCount(bufferScreen, operatorKeys) > 1))
                    || (operatorKeys.includes(action) && (bufferScreen.startsWith('-') && stringContainsElementCount(bufferScreen, operatorKeys) > 2))
                ) {

                    screen = screen.replace(new RegExp(/[^0-9\*\-\+\/\.]/g), '')

                    if(isFirstNegative = (screen.slice(0, 1) === '-')){
                        inputBuffer = screen.slice(1);
                    }else {
                        inputBuffer = screen;
                    }

                    let parts = inputBuffer.split(/[\*\-\+\/\/]/);
                    let one = parts[0];
                    let two = parts[1];
                    let operator = inputBuffer.match(/[\*\+\-\/]/)[0];

                    if(isFirstNegative){
                        one *= -1;
                    }

                    fetch('/api', {
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({operandOne: one, operandTwo: two, operator: operator}),
                        method: "POST",
                    }).then((response) => {
                        if (response.status !== 200) {
                            throw Error();
                        }
                        return response.json();
                    }).then(data => {
                        let history = '';
                        for (let item of data.history) {
                            history += `<div>${item.statement}</div>`;
                        }
                        screenElement.innerText = screen = data.result.toString();
                        historyElement.innerHTML = history;
                    }).catch(() => drawAlert('Invalid input'));
                } else {
                    screen += action;
                }
                screenElement.innerText = screen;
            })
        })
    }
});
