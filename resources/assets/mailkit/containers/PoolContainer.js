import React from 'react'
import {Component} from "react"
import {connect} from "react-redux"
import {poolList, poolAdd, poolAPIAdd, poolDel, poolUpd, getPoolList, poolSelect, poolAPIList} from '../actions'

class PoolContainer extends Component {
    componentDidMount() {
        this.props.listPool('')
    }
    componentDidUpdate() {}
    componentWillUnmount() {}

    render() {
        return (
            <div>
                <div className="modal fade" id="poolDetails" tabIndex="-1" role="dialog">
                    <div className="modal-dialog" role="document">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title">Pool Details</h5>
                                <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div className="modal-body">
                                <input type="text" className="form-control" placeholder="pool name..." ref="name"
                                       value={this.props.state.dummy.name} onChange={e => console.log('this: ', this)} />
                                <input type="text" className="form-control" placeholder="pool description..." ref="description"
                                       value={this.props.state.dummy.description} onChange={e => console.log('this: ', this)} />
                            </div>
                            <div className="modal-footer">
                                <button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" className="btn btn-primary" data-dismiss="modal"
                                        onClick={() => {
                                            this.props.addPool(this.refs.name.value, this.refs.description.value)
//                                            $('#myModal').modal('hide')
                                        }}>Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="input-group flex-nowrap">
                    <div className="input-group-prepend">
                        <span className="input-group-text" id="basic-addon1">Pools</span>
                    </div>
                    <input type="text" className="form-control" placeholder="filter..."
                           defaultValue={this.props.state.filter} onChange={e => console.log('this: ', this)} />
                </div>
                <div className="list-group">
                    {
                        this.props.state.pools.map(item => {
                            let activeClass = this.props.state.selected === item.id ? ' active': ''
                            let enabledClass = item.enabled ? '' : ' disabled'
                            return (
                                <a href="#" onClick={e => this.props.selectPool(item.id)}
                                    key={item.id}
                                    className={"list-group-item list-group-item-action" + activeClass + enabledClass}>
                                    {item.name}
                                </a>
                            )
                        })
                    }
                </div>
                <div>
                    <button type="button" className="btn btn-success" data-toggle="modal" data-target="#poolDetails">+</button>
                    {/*<button type="button" className="btn btn-success" onClick={e => this.props.addPool()}>+</button>*/}

                    {
                        (this.props.state.selected !== false) &&
                            <React.Fragment>
                                <button type="button" className="btn btn-primary"
                                    onClick={e => {
                                        let newName = prompt("New name", this.props.state.pools.find(i => i.id == this.props.state.selected).name)
                                        console.log(newName)
                                        if (newName != null) this.props.updPool(this.props.state.selected, newName)
                                    }}>...
                                </button>
                                <button type="button" className="btn btn-danger"
                                    onClick={e => this.props.delPool(this.props.state.selected)}>-
                                </button>
                            </React.Fragment>
                    }
                </div>

                {this.props.state.error.state == true &&
                <div className="alert alert-danger" role="alert">
                    {this.props.state.error.message}
                </div>
                }

                {this.props.state.updating == true &&
                <img src="spinner.gif" />
                }
            </div>
        )
    }
}

const mapStateToProps = store => {
    return {
        state: store.poolState
    }
}

const mapDispatchToProps = (dispatch, ownProps) => {
    return {
        selectPool: id => dispatch(poolSelect(id)),
        listPool: filter => dispatch(poolAPIList(filter)),
        addPool: (name, description) => dispatch(poolAPIAdd(name, description)),
        delPool: id => dispatch(poolDel(id)),
        updPool: (id, name) => dispatch(poolUpd(id, name))
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(PoolContainer)