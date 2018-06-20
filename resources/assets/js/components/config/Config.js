import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from "axios/index";
import _ from 'lodash'

import { RIEToggle, RIEInput, RIETextArea, RIENumber, RIETags, RIESelect } from 'riek'
import Example from "../Example";


// {props.item.id} => {props.item.name}
// attr('id')

class Config extends Component {
/*
    constructor(props) {
        super(props);
        this.state = {
            id: this.props.item.id,
            name: this.props.item.name || "default name"
        };
    }
    componentDidMount() {
    }

    httpTaskCallback(task) {
        axios.put('/api/configs/', {
            data: task
        })
            .then(res => {
                console.log(res);
                this.setState({configItems: [...this.state.configItems, res.data.data]})
            })
    };
<RIEInput
value={this.state.name}
change={this.httpTaskCallback}
propName='name'
validate={_.isString} />

    <button type="button" className="btn btn-success">Edit</button>
    <button type="button" className="btn btn-danger" onClick={(e) => this.props.eventList.delConfig(e)}>Delete</button>
    <button type="button" className="btn btn-danger" onClick={(e) => this.props.eventList.generateConfig(e)}>Generate</button>

*/
    render() {
        return (
            <div id={this.props.config.id}>{this.props.config.name}</div>
        );
    }
}

export default Config;
