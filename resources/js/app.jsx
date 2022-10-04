/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

//require('./bootstrap');

import 'bootstrap';

import React from 'react';
import {render} from 'react-dom';

import {BrowserRouter as Router, Route, Link} from 'react-router-dom';

import {createStore} from 'redux';
import {Provider} from 'react-redux'
import rootReducer from './reducers'

import ConfigListContainer from "./components/config/ConfigListContainer";
import CreateItem from './components/CreateItem';
import DisplayItem from "./components/DisplayItem";
import EditItem from "./components/EditItem";

const store = createStore(rootReducer)

render(
    <Provider store={store}>
        <Router basename="/home/">
            <div>
                <ul>
                    <li><Link to="add-item">Create Item</Link></li>
                    <li><Link to="display-item">Display Item</Link></li>
                    <li><Link to="configs">Configs</Link></li>
                </ul>
                <Route exact path="/" component={DisplayItem}/>
                <Route path="/configs" component={ConfigListContainer}/>
                <Route path="/add-item" component={CreateItem}/>
                <Route path="/edit/:id" component={EditItem}/>
            </div>
        </Router>
    </Provider>
    ,
    document.getElementById('example'));
