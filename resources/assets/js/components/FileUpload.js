import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Dropzone from 'react-dropzone';
import axios from 'axios';

const FileUpload = ({children}) => (
    <Dropzone className="ignore" onDrop={OnDropHandler}>
        {children}
    </Dropzone>
);

const OnDropHandler = (files) => {
    var data = new FormData();
    files.forEach(file => {
        data.append(file.name, file);
    });

    axios.post('/api/upload', data)
        .then(function (res) {
            console.log(res)
        })
        .catch(function (err) {
            console.log(err)
        });
}
export default FileUpload;

