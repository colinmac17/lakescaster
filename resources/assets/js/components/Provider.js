import React, { Component, Fragment } from 'react';
import axios from "axios/index";

const MyContext = React.createContext();

export default class Provider extends Component{
    constructor(props){
        super(props)
        this.state = {
            apiPath: this.props.apiPath,
            path: this.props.path,
            data: [],
            date: this.props.date,
            name: this.props.name
        }
    }

    componentWillMount(){
        const path = this.state.apiPath
        axios.get(path)
            .then((res) => {
                this.setState({data: res.data})
            }).catch(err => console.log(err))
    }

    render(){
        return(
            <MyContext.Provider
                value={{
                state: this.state
            }}>
                {this.props.children}
            </MyContext.Provider>
        )
    }
}

export {MyContext};