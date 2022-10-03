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

<<<<<<< HEAD
        $table->increments('id');
        $table->string('name');
        $table->string('connection');
        $table->string('login');
        $table->string('password');
        $table->boolean('enabled')->default(true);
=======
//        $table->increments('id');
//        $table->string('name');
//        $table->string('connection');
//        $table->string('login');
//        $table->string('password');
//        $table->boolean('enabled')->default(true);
>>>>>>> d084c4339bda30d7c3847b94f98bca0d50a6ea7c

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

<<<<<<< HEAD
export default connect(mapStateToProps, mapDispatchToProps)(SourceContainer)
=======
export default connect(mapStateToProps, mapDispatchToProps)(SourceContainer)
>>>>>>> d084c4339bda30d7c3847b94f98bca0d50a6ea7c
