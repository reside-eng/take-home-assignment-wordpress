describe('Validate Setup', () => {
    it('Theme and Plugin are activated', () => {
      cy.visit( '/' );
      cy.get('#side-plugin-styles-css');
      cy.get('#side-theme-styles-css');
      cy.get('#side-plugin-scripts-js');
      cy.get('#side-theme-scripts-js');
    })
})