const minus= (a, b) => {
    return a - b;
};

describe('should subtract two numbers', () => {
    test('one plus two equals three', () => {
        expect(minus(2,1)).toBe(1);
    });
    test('ten minus four equals 6', () => {
        expect(minus(10,4)).toBe(6);
    });
});