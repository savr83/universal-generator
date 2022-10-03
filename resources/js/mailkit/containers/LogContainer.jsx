import React from 'react'
import {Component} from "react"
import {connect} from "react-redux"

class LogContainer extends Component {
    componentDidMount() {}
    componentDidUpdate() {}
    componentWillUnmount() {}

    render() {
        return (
            <div>Log:</div>
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

export default connect(mapStateToProps, mapDispatchToProps)(LogContainer)