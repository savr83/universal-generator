import 'bootstrap'
import React from 'react'
import {render} from 'react-dom'
import {BrowserRouter as Router, Route, Link, NavLink} from 'react-router-dom'
import {Provider} from 'react-redux'


import store from './store/configureStore'

import PoolContainer from './containers/PoolContainer'
import RootContainer from './containers/RootContainer'
import SourceContainer from './containers/SourceContainer'
import RuleContainer from './containers/RuleContainer'
import FilterContainer from './containers/FilterContainer'
import LogContainer from './containers/LogContainer'

render(
    <Provider store={store}>
        <Router basename="generator/mailkit">
            <div className="row">
                <div className="col col-3">
                    <PoolContainer/>
                </div>
                <div className="col col-9">
                    <nav className="nav nav-pills">
                        <NavLink to="sources" className={"nav-link" + " active"}>Sources</NavLink>
                        <NavLink to="rules" className="nav-link">Rules</NavLink>
                        <NavLink to="filters" className="nav-link">Filters</NavLink>
                        <NavLink to="logs" className="nav-link">Logs</NavLink>
                    </nav>
                    <Route exact={true} path="/" component={RootContainer} />
                    <Route path="/sources" component={SourceContainer} />
                    <Route path="/rules" component={RuleContainer} />
                    <Route path="/filters" component={FilterContainer} />
                    <Route path="/logs" component={LogContainer} />
                </div>
            </div>
        </Router>
    </Provider>
    ,
    document.getElementById('root'));
