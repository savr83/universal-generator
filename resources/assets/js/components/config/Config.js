import React from 'react';


/*
простой презентационный компонент (глупый, stateless)
представляет единственную функцию - render() не имеет логики, отвечает только за отрисовку состояния взятую из props
props -- аргумент arrow-функции переданных в компонент значений в месте использования компонента, например ConfigList.js:
<Config config={config} />

(props) => value
если требуются дополнительные операции перед возвращением значния:
(props) => {
  ...
  return value;
}
эквивалентно старой форме:
function(props) {
  ...
  return value;
}
*/

const Config = props => {
    return (
        <span id={props.config.id}>{props.config.name}</span>
    );
}

export default Config;
