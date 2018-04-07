import React, { Component, Fragment } from 'react';
import { toggleDescription } from '../reactHelpers';
import axios from "axios";

const MyContext = React.createContext();

export default class Provider extends Component{
    constructor(props){
        super(props)
        this.state = {
            apiPath: this.props.apiPath,
            path: this.props.path,
            data: null,
            date: this.props.date,
            name: this.props.name,
            description: this.props.description
        }
    }

    componentDidMount(){
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