import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import List from './List'
import axios from 'axios';

import ReactTable from "react-table";
import 'react-table/react-table.css';
import { Button, Icon } from 'semantic-ui-react';
import FileUpload from './FileUpload';


import Example from "./Example";

//import $ from 'jquery';

class Main extends Component {
    constructor(props) {
        super(props);
        this.configEvents = {
            delConfig: this.delConfig,
            generateConfig: this.generateConfig,
//            ex: Example,
            context: this
        };

        this.state = {
            newStateName: '',
            configItems: props.configItems || [],
            testData: []
        };
        axios.create({
            xsrfHeaderName: window.Laravel.csrfToken
        });

        this.columns = [{
            Header: 'Модель',
            accessor: 'MODEL' // String-based value accessors!
        }, {
            Header: 'Моща',
            accessor: 'POWER',
        }, {
            Header: 'Бабло',
            accessor: 'PRICE'
        }, {
            Header: 'Вольтаж',
            accessor: 'VOLTAGE'
        }]
    }

    componentDidMount() {
//        axios.get(`/redirect_code/${this.props.subreddit}.json`)
        axios.get('/redirect_code/')
        .then(res => {
            axios.defaults.headers.common['Authorization'] = res.data.token_type + ' ' + res.data.access_token;
            axios.get('/api/configs')
                .then(res => {
                    this.setState({ configItems: res.data.data });
                })
        });
    }

    newStateNameChange(e) {
        this.setState({ newStateName: e.target.value })
    }

    addConfig(e) {
        axios.post('/api/configs/', {
            data: {
                name: this.state.newStateName
            }
        })
            .then(res => {
                console.log(res);
                this.setState({configItems: [...this.state.configItems, res.data.data]})
            })
    }

    generateConfig(e) {
        axios.get(`/api/configs/generate/1`) //${e.target.parentNode.id}`)
            .then(res => {
                console.log(res);
                this.setState({testData: res.data.out})
//                this.setState({configItems: [...this.state.configItems, res.data.data]})
            })
    }

    delConfig(e) {
        axios.delete(`/api/configs/${e.target.parentNode.id}`)
            .then(res => {
                // console.log(res, 'this', this, 'context', this.context, 'event', e);
                // e.target.parentNode.id
                if (res.data.msg == 'success') this.context.setState({configItems: this.context.state.configItems.filter(item => item.id != res.data.id )})
                else console.log(res.data.msg);
            })
            .catch(err => {
                console.log(err);
            })
    }

    render() {
        return <div className="container">
            <div className="row justify-content-center">
            {/* форма загрузки файла */}
            <FileUpload>
                <Button icon>
                    <Icon name="plus square" />
                </Button>
            </FileUpload>
                <ReactTable data={this.state.testData} columns={this.columns} />


            </div>
            <button type="button" className="btn btn-sm btn-danger" onClick={(e) => this.generateConfig(e)}>Generate
            </button>
         </div>;

    }
}

export default Main;
// configItems={["123", "asd"]}

{/*
<div className="col-6">
    <input type="text" onChange={(e) => this.newStateNameChange(e)} />
    <button type="button" className="btn btn-primary" onClick={(e) => this.addConfig(e)}>Add</button>
    <List items={this.state.configItems} listType='config' eventList={this.configEvents} />
</div>
<div className="col-6">
    <button type="button">Test</button>
</div>
*/}


if (document.getElementById('root')) {
    ReactDOM.render(<Main />, document.getElementById('root'));
}
