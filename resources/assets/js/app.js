import $ from "jquery";

/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

//import Main from './components/Main';
import 'bootstrap';

import React from 'react';
import {render} from 'react-dom';
import {BrowserRouter as Router, Route, Link} from 'react-router-dom';
//import Master from './components/Master';
import CreateItem from './components/CreateItem';
import DisplayItem from "./components/DisplayItem";
import EditItem from "./components/EditItem";

// <Route path="/display-item" component={DisplayItem} />
render(
    <Router basename="/home/">
        <div>
            <ul>
                <li><Link to="add-item">Create Item</Link></li>
                <li><Link to="display-item">Display Item</Link></li>
            </ul>
            <Route exact path="/" component={DisplayItem} />
            <Route path="/add-item" component={CreateItem} />
            <Route path="/edit/:id" component={EditItem} />
        </div>
    </Router>
    ,
    document.getElementById('example'));
