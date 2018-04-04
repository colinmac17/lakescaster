//import { add } from '../helpers';

const add = (a, b) => {
    return a + b;
};

test('should add two numbers', () => {
    expect(add(1,2)).toBe(3);
    expect(add(4,12)).toBe(16);
});