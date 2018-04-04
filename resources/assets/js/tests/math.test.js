import {add, minus} from './tests';

describe('minus', () => {
    it('should subtract two numbers', () => {
        expect(minus(2,1)).toBe(1);
        expect(minus(7,3)).toBe(4);
        expect(minus(10,2)).toBe(8);
    });
});

describe('add', () => {
    it('should add two numbers', () => {
        expect(add(1,2)).toBe(3);
        expect(add(4,12)).toBe(16);
    });
});