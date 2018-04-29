import React, {Component, Fragment} from 'react';
import StarRatingComponent from 'react-star-rating-component';
import axios from 'axios';
import $ from 'jquery';

class ReviewModal extends Component {
    constructor(props){
        super(props)
        this.state = {
            rating: 0,
            review: "",
            showStatus: false,
            statusType: 'success'
        }

        this.onStarClick = this.onStarClick.bind(this)
        this.handleReviewSubmit = this.handleReviewSubmit.bind(this)
        this.handleChange = this.handleChange.bind(this)
        this.handleClose = this.handleClose.bind(this)
    }

    onStarClick(nextValue, prevValue, name){
        this.setState({rating: nextValue})
    }

    handleChange(e) {
        let change = {}
        change[e.target.name] = e.target.value
        this.setState(change)
    }

    handleReviewSubmit(e){
        e.preventDefault()
        const {rating, review} = this.state
        axios.post(`/${this.props.path}/review`, {rating: rating, review: review})
            .then((response) => {
                $('button[data-dismiss="modal"]').click()
                if(response.status === 200){
                    this.setState({showStatus: true, statusType: 'success'})
                    $('#statusModal').show()
                } else {
                    this.setState({showStatus: true, statusType: 'failure'})
                }
            })
                .catch((err) => {
                    this.setState({showStatus: true, statusType: 'failure'})
                 })
    }

    handleClose(){
        this.setState({showStatus: false})
        location.reload(true)
    }

    render(){
        const {rating} = this.state
        return(
            <Fragment>
                <div className="modal" id={(this.props.action === 'post') ? 'reviewModal' : ((this.props.action === 'edit') ? 'editReviewModal' : 'deleteReviewModal')} tabIndex="-1" role="dialog" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered" role="document">
                        <div className="modal-content">
                            <div className="modal-header">
                                {this.props.action == 'post' ?
                                    <h5 className="modal-title">Review for <span
                                        className="text-primary">{this.props.spotname}</span></h5>
                                    : (this.props.action == 'edit') ?
                                        <h5 className="modal-title">Edit Review for <span
                                            className="text-primary">{this.props.spotname}</span></h5> :
                                        <h5 className="modal-title">Delete Review for <span
                                            className="text-primary">{this.props.spotname}</span></h5>
                                }
                                <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div className="modal-body">
                                <form onSubmit={this.handleReviewSubmit} method="POST" action={"/" + this.props.path + "/review" + "?bAction=" + this.props.action}>
                                    <div className="form-group">
                                        <label htmlFor="review" className="col-form-label">Rating:</label><br/>
                                        <StarRatingComponent
                                            name="review"
                                            starCount={5}
                                            value={rating}
                                            onStarClick={this.onStarClick}
                                        />
                                    </div>
                                    <div className="form-group">
                                        {/*<label htmlFor="message-text" className="col-form-label">Comment:</label>*/}
                                        <textarea onChange={this.handleChange} name="review" placeholder="leave a review" className="form-control" id="message-text"></textarea>
                                    </div>
                                    <div className="modal-footer">
                                        <button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" className="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {this.state.showStatus
                    ?
                <div className="status-modal">
                    <div id="statusModal" className="modal" tabIndex="-1" role="dialog" aria-labelledby="statusModal">
                        <div className="modal-dialog modal-dialog-centered" role="document">
                            <div className="modal-content">
                                <div className="modal-header">
                                    <h5 className={this.state.statusType === 'success' ? 'modal-title text-success' : 'modal-title text-danger'}>{this.state.statusType}</h5>
                                    <button type="button" onClick={this.handleClose} className="close" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div className="modal-body">
                                    {this.state.statusType === 'success'
                                    ?  <p>Thank you, your review has been successfully saved!.</p>
                                        :
                                        <p>Sorry, we had an error processing your review. Please refresh the page and try again and if still not working contact the developer at colin@colinmcatee.com</p>
                                    }
                                </div>
                                <div className="modal-footer">
                                    <button onClick={this.handleClose} type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    : ""
                }
            </Fragment>
        )
    }
}

export {ReviewModal};