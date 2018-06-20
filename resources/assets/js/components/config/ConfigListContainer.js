import React from 'react';
import {Component} from "react";
import ConfigList from "./ConfigList";
import {connect} from "react-redux";
import {addConfig, delConfig, newConfigNameUpdate} from "../../actions";

class ConfigListContainer extends Component {
    componentDidMount() {
        /*
        axios.get('/path/to/user-api').then(response => {
            store.dispatch({
                type: 'USER_LIST_SUCCESS',
                users: response.data
            });
        });
        */
    }

    render() {
        return (
            <div>
                <input type="text" onChange={e => this.props.newConfigNameUpdate(e.target.value)} value={this.props.newConfigName} />
                <button onClick={e => this.props.addConfig(this.props.newConfigName)}>New config</button>
                <ConfigList configs={this.props.configs} delConfig={this.props.delConfig}/>
            </div>
        );
    }
}

const mapStateToProps = function (store) {
    return {
        newConfigName: store.configState.newConfigName,
        configs: store.configState.configs
    }
}

const mapDispatchToProps = function (dispatch, ownProps) {
    return {
        addConfig: (id, name) => {
            dispatch(addConfig(id, name))
        },
        delConfig: id => {
            dispatch(delConfig(id))
        },
        newConfigNameUpdate: name => {
            dispatch(newConfigNameUpdate(name))
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(ConfigListContainer)
