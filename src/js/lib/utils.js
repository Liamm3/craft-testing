export const pascalCaseToSnakeCase = s =>
  s.replace(/[A-Z]/g, letter => `_${letter.toLowerCase()}`);
