import React, {Component} from 'react';
import {Form, FormGroup, InputGroup, FormControl, Button, Alert} from 'react-bootstrap';
import SearchResults from './SearchResults';

export default class App extends Component {

    api = '../../api/v1/';

    state = {
        query: '',
        results: [],
        responses: 0,
        searching: false
    }

    constructor(props) {
        super(props);

        this.handleChange = this.handleChange.bind(this);
        this.handleSearch = this.handleSearch.bind(this);
    }

    render() {
        return (
            <div>
                <div className="container readable-width">
                    <div className="page-header">
                        <h1>St. Mark’s Search</h1>
                    </div>
                </div>

                <div className="container readable-width">
                    <Form onSubmit={this.handleSearch}>
                        <FormGroup>
                            <InputGroup>
                                <FormControl type="text" name="query" value={this.state.query}
                                             onChange={this.handleChange}/>
                                <InputGroup.Button>
                                    <Button className="btn-primary" type="submit">Search</Button>
                                </InputGroup.Button>
                            </InputGroup>
                            <p className="help-block">Searching <span id="domain-count">a few</span> sources</p>
                        </FormGroup>
                    </Form>
                </div>

                <div className="container readable-width">
                    <SearchResults results={this.state.results} searching={this.state.searching} domains={this.state.domains} responses={this.state.responses} />
                </div>

                <div className="container readable-width">
                    <Alert className="alert-warning">
                        This is a project very, very much <a className="alert-link"
                                                             href="https://github.com/smtech/stmarks-search/issues">under
                        development</a> at the moment. Please <a className="alert-link"
                                                                 href="mailto:sethbattis@stmarksschool.org?subject=St.+Mark%92s+Search">share
                        feedback with Seth</a>!
                    </Alert>
                </div>
            </div>
        );
    }

    fetchJSON(url, params, callback) {
        fetch(url, params)
            .then(response => response.json())
            .then(callback);
    }

    replace(id, html) {
        document.getElementById(id).innerHTML = html;
    }

    componentDidMount() {
        const self = this;
        this.fetchJSON(this.api + 'domains', {method: 'get'}, function (domainCount) {
            self.replace('domain-count', domainCount);
            self.setState({domains: domainCount});
        });
    }

    handleChange(event) {
        this.setState({query: event.target.value});
    }

    handleSearch(event) {
        const self = this;
        document.title = 'St. Mark’s Search: ' + this.state.query;
        this.setState({responses: 0, results: [], searching: true});
        for (var i = 0; i < this.state.domains; i++) {
            this.fetchJSON(
                this.api + 'search/' + i + '?query=' + this.state.query,
                {method: 'get'},
                function (results) {
                    var sortableResults = [
                        ...self.state.results,
                        ...results
                    ]
                    sortableResults.sort(function (a, b) {
                        /* we want results in _descending_ order of relevance.score */
                        return b.relevance.score - a.relevance.score
                    });
                    self.setState({
                        results: sortableResults,
                        responses: self.state.responses + 1
                    });
                    if (self.state.responses >= self.state.domains) {
                        self.setState({searching: false});
                    }
                }
            );
        }
        event.preventDefault();
    }
}
