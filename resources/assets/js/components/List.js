import React, {Component} from 'react';
import Example from "./Example";
import Config from "./Config";


const listTypes = {
    config: Config,
    ex: Example
}

class List extends Component {
//    constructor(props) {
//        super(props);
        // this.state = {
        //     id: this.props.item.id,
        //     name: this.props.item.name || "default name"
        // };
//    }
    componentDidMount() {
    }

//const List = props => {
    render() {
        let ListItem = listTypes[this.props.listType];
        return (
            <ul>
                {
                    this.props.items.map((item) => <li key={item.id}><ListItem item={item} eventList={this.props.eventList} />
                    </li>)
                }
            </ul>
        );
    }
}
export default List;
