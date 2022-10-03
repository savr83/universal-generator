import React from 'react'
import {Component} from "react"
import {connect} from "react-redux"

class SourceContainer extends Component {
    componentDidMount() {}
    componentDidUpdate() {}
    componentWillUnmount() {}

    render() {
        return (
            <div>Sources:</div>

//        $table->increments('id');
//        $table->string('name');
//        $table->string('connection');
//        $table->string('login');
//        $table->string('password');
//        $table->boolean('enabled')->default(true);

        )
    }
}

const mapStateToProps = function (store) {
    return {
        // newConfigName: store.configState.newConfigName,
        // configs: store.configState.configs
    }
}

const mapDispatchToProps = function (dispatch, ownProps) {
    return {
        // addConfig: (id, name) => {
        //     dispatch(addConfig(id, name))
        // },
        // delConfig: id => {
        //     dispatch(delConfig(id))
        // },
        // newConfigNameUpdate: name => {
        //     dispatch(newConfigNameUpdate(name))
        // }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(SourceContainer)
