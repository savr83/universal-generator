import React from 'react';
import Config from "./Config";

const ConfigList = props => {
    console.log('props', props);
    return (
        <ul>
            {
                props.configs.map((config, key) => <li key={key}><Config config={config} /><button onClick={e => props.delConfig(config.id)} /></li> )
            }
        </ul>
    );
}

export default ConfigList;
