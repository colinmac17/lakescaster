import React, {Component, Fragment} from 'react';

class Media extends Component{
    constructor(props) {
        super(props)
        this.state = {
            data: {}
        }
    }

    componentWillMount(){
        this.setState({
            data: this.props.state
        })
    }

    render(){
        return(
            <h1>Media</h1>
        )
    }
}

export default Media;