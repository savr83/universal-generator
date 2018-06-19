import React, {Component} from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';
import TableRow from './TableRow';

class DisplayItem extends Component {
    constructor(props) {
        super(props);
        this.state = {value: '', category: ''};
    }
    componentDidMount(){
        axios.get('/api/categories')
            .then(response => {
                this.setState({ category: response.data.data });
            })
            .catch(function (error) {
                console.log(error);
            })
    }
    tabRow(){
        if(this.state.category instanceof Array){
            return this.state.category.map(function(object, i){
                return <TableRow obj={object} key={i} />;
            })
        }
    }


// <div className="row">
// <div className="col-md-10"></div>
// <div className="col-md-2">
// <Link to="/add-item">Create Category</Link>
// </div>
// </div><br />
    render(){
        return (
            <div>
                <h1>Categories</h1>
                <table className="table table-hover">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Parent ID</td>
                        <td>Category Name</td>
                        <td>Actions</td>
                    </tr>
                    </thead>
                    <tbody>
                    {this.tabRow()}
                    </tbody>
                </table>
            </div>
        )
    }
}
export default DisplayItem;
