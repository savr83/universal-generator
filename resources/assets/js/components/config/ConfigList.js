import React from 'react';
import Config from "./Config";

/*
простой презентационный компонент (глупый, stateless)
идентичен Config.js но используется для списков с помощью .map(), подробности:
https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/map
*/

const ConfigList = props => {
    return (
        <ul>
            {
                props.configs.map((config, key) => <li key={key}><Config config={config} /><button onClick={e => props.delConfig(config.id)} /></li> )
            }
        </ul>
    );
}

export default ConfigList;
