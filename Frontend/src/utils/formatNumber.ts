// src/utils/formatNumber.ts
export const formatNumber = (value: number): string => {
  // Utilise le format français pour le rendu de la valeur
  const formattedValue = new Intl.NumberFormat('fr-FR').format(value);

  if (value >= 1_000_000_000) {
    return `${(value / 1_000_000_000).toFixed(1)}B`; // Format pour milliard
  }
  if (value >= 1_000_000) {
    return `${(value / 1_000_000).toFixed(1)}M`; // Format pour million
  }
  if (value >= 1_000) {
    return `${(value / 1_000).toFixed(1)}K`; // Format pour millier
  }
  return formattedValue; // Retourne la valeur formatée si elle est inférieure à 1000
};
