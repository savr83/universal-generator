import React, {Component} from "react";
import {connect} from "react-redux";
// import {addConfig, delConfig, newConfigNameUpdate} from "../../actions";

import TmpList from "./TmpList";

class TmpListContainer extends Component {
    componentDidMount() {
    }
    componentDidUpdate() {
    }
    componentWillUnmount() {
    }
    render() {
        return (
            <div>
                <input type="text" onChange={e => this.props.newConfigNameUpdate(e.target.value)} value={this.props.newConfigName} />
                <Button className="btn btn-primary" onClick={e => this.props.addConfig(this.props.newConfigName)}>New config</Button>
                <TmpList propname={this.props.configs} delConfig={this.props.delConfig}/>
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

export default connect(mapStateToProps, mapDispatchToProps)(TmpListContainer)
