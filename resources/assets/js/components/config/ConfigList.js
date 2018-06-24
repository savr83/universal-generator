import React from 'react';
import Config from "./Config";
import {Button} from 'react-bootstrap';
import {BootstrapTable, TableHeaderColumn} from "react-bootstrap-table";

/*
простой презентационный компонент (глупый, stateless)
идентичен Config.js но используется для списков с помощью .map(), подробности:
https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/map
*/

// {/*<ul>*/}
// {/*{*/}
// {/*props.configs.map((config, key) => <li key={key}><Config config={config} /><Button className="btn btn-danger" onClick={e => props.delConfig(config.id)}> Del</Button></li> )*/}
// {/*}*/}
// {/*</ul>*/}

/*
const ConfigList = props => {
    return (
        <table>
            <thead>
            <tr>
                <td>Name</td><td>Action</td>
            </tr>
            </thead>
            <tbody>
            {
                props.configs.map((config, key) => <tr key={key}>
                    <td><Config config={config}/></td>
                    <td><Button className="btn btn-danger" onClick={e => props.delConfig(config.id)}> Del</Button></td>
                </tr>)
            }
            </tbody>
        </table>
    );
}

*/


const ConfigList = props => {
    let table;
    const handleDeleteButtonClick = (onClick) => {
        console.log('this:', this, "table", table, "this.refs", this.refs);
        this.refs.table.selectedRowKeys.map(id => props.delConfig(id))
//        onClick();
    }
    const options = {
        deleteBtn: (onBtnClick) => {
            return (
                <button style={{color: 'red'}} onClick={e => handleDeleteButtonClick(onBtnClick)}>Delete it!!!</button>
            );
        }
    }
    const selectRow = {
        mode: 'checkbox'
    }
    return (
        <BootstrapTable ref={table} selectRow={selectRow} data={props.configs} options={options} striped hover
                        condensed deleteRow>
            <TableHeaderColumn dataField='id' isKey>Config ID</TableHeaderColumn>
            <TableHeaderColumn dataField='name'>Config Name</TableHeaderColumn>
        </BootstrapTable>
    );
}


export default ConfigList;
