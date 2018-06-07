'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var RPS = function (_React$Component) {
    _inherits(RPS, _React$Component);

    function RPS(props) {
        _classCallCheck(this, RPS);

        var _this = _possibleConstructorReturn(this, (RPS.__proto__ || Object.getPrototypeOf(RPS)).call(this, props));

        _this.state = {
            userChoice: ' ',
            cpuChoice: ' ',
            battleResult: " "
        };

        _this.handleChoice = _this.handleChoice.bind(_this);
        return _this;
    }

    _createClass(RPS, [{
        key: 'handleChoice',
        value: function handleChoice(e) {
            var myArray = ['rock', 'paper', 'scissors'];
            var rand = myArray[Math.floor(Math.random() * myArray.length)];
            var usr = e.target.value;
            var cpu = rand;
            var battle = this.findWinner(usr, cpu);
            this.setState({ userChoice: usr, cpuChoice: cpu, battleResult: battle });
        }
    }, {
        key: 'findWinner',
        value: function findWinner(user, cpu) {
            if (user === cpu) {
                return "It was a tie";
            }
            var tmp = "someone else won";
            if (user === "rock") {
                tmp = cpu === "paper" ? "You lost" : "You won";
            } else if (user === "paper") {
                tmp = cpu === "scissors" ? "You lost" : "You won";
            } else {
                tmp = cpu === "rock" ? "You lost" : "You won";
            }
            return tmp;
        }
    }, {
        key: 'render',
        value: function render() {
            return React.createElement(
                'div',
                null,
                React.createElement(
                    'form',
                    null,
                    React.createElement(
                        'label',
                        null,
                        'Select:',
                        React.createElement(
                            'select',
                            { className: 'rpsselect', onChange: this.handleChoice },
                            React.createElement(
                                'option',
                                { value: 'rock' },
                                'Rock'
                            ),
                            React.createElement(
                                'option',
                                { value: 'paper' },
                                'Paper'
                            ),
                            React.createElement(
                                'option',
                                { value: 'scissors' },
                                'Scissors'
                            )
                        )
                    )
                ),
                React.createElement(
                    'p',
                    null,
                    ' You selected ',
                    this.state.userChoice,
                    ' '
                ),
                React.createElement(
                    'p',
                    null,
                    ' The CPU selected ',
                    this.state.cpuChoice,
                    ' '
                ),
                React.createElement(
                    'p',
                    null,
                    ' ',
                    this.state.battleResult,
                    ' '
                )
            );
        }
    }]);

    return RPS;
}(React.Component);

ReactDOM.render(React.createElement(RPS, null), document.getElementById('rps'));