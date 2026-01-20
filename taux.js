import React, { useState } from 'react';
import { Save, Settings, DollarSign, Calendar, Clock, AlertCircle } from 'lucide-react';

export default function CollecteConfig() {
  const [activeTab, setActiveTab] = useState('taux');
  const [config, setConfig] = useState({
    tauxPrincipal: 2.5,
    tauxType: 'pourcentage',
    montantMinimum: 1000,
    montantMaximum: 100000,
    frequence: 'quotidienne',
    joursCollecte: ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi'],
    heureCollecte: '08:00',
    penaliteRetard: 5,
    fraisTraitement: 500,
    devise: 'XAF',
    periodeEssai: 7,
    notificationAvant: 24
  });

  const [paliers, setPaliers] = useState([
    { min: 0, max: 50000, taux: 2.5 },
    { min: 50001, max: 200000, taux: 2.0 },
    { min: 200001, max: 999999999, taux: 1.5 }
  ]);

  const handleConfigChange = (field, value) => {
    setConfig(prev => ({ ...prev, [field]: value }));
  };

  const toggleJour = (jour) => {
    setConfig(prev => ({
      ...prev,
      joursCollecte: prev.joursCollecte.includes(jour)
        ? prev.joursCollecte.filter(j => j !== jour)
        : [...prev.joursCollecte, jour]
    }));
  };

  const handleSave = () => {
    console.log('Configuration sauvegardée:', config, paliers);
    alert('Configuration sauvegardée avec succès !');
  };

  const jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];

  return (
    <div className="min-h-screen bg-gray-50 p-6">
      <div className="max-w-6xl mx-auto">
        {/* En-tête */}
        <div className="bg-white rounded-lg shadow-sm p-6 mb-6">
          <div className="flex items-center justify-between">
            <div>
              <h1 className="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <Settings className="text-blue-600" size={32} />
                Configuration de Collecte
              </h1>
              <p className="text-gray-600 mt-2">Gérez les taux, conditions et paramètres de collecte journalière</p>
            </div>
            <button
              onClick={handleSave}
              className="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 flex items-center gap-2 font-medium"
            >
              <Save size={20} />
              Enregistrer
            </button>
          </div>
        </div>

        {/* Navigation par onglets */}
        <div className="bg-white rounded-lg shadow-sm mb-6">
          <div className="border-b border-gray-200">
            <nav className="flex gap-1 p-1">
              {[
                { id: 'taux', label: 'Taux de Collecte', icon: DollarSign },
                { id: 'conditions', label: 'Conditions', icon: AlertCircle },
                { id: 'planning', label: 'Planning', icon: Calendar },
                { id: 'paliers', label: 'Paliers Progressifs', icon: Settings }
              ].map(tab => (
                <button
                  key={tab.id}
                  onClick={() => setActiveTab(tab.id)}
                  className={`flex items-center gap-2 px-6 py-3 rounded-lg font-medium transition-colors ${
                    activeTab === tab.id
                      ? 'bg-blue-50 text-blue-700 border-b-2 border-blue-600'
                      : 'text-gray-600 hover:bg-gray-50'
                  }`}
                >
                  <tab.icon size={18} />
                  {tab.label}
                </button>
              ))}
            </nav>
          </div>

          <div className="p-6">
            {/* Onglet Taux */}
            {activeTab === 'taux' && (
              <div className="space-y-6">
                <div className="grid grid-cols-2 gap-6">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Type de taux
                    </label>
                    <select
                      value={config.tauxType}
                      onChange={(e) => handleConfigChange('tauxType', e.target.value)}
                      className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                      <option value="pourcentage">Pourcentage (%)</option>
                      <option value="fixe">Montant fixe</option>
                    </select>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      {config.tauxType === 'pourcentage' ? 'Taux principal (%)' : 'Montant fixe'}
                    </label>
                    <input
                      type="number"
                      step="0.1"
                      value={config.tauxPrincipal}
                      onChange={(e) => handleConfigChange('tauxPrincipal', parseFloat(e.target.value))}
                      className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Frais de traitement ({config.devise})
                    </label>
                    <input
                      type="number"
                      value={config.fraisTraitement}
                      onChange={(e) => handleConfigChange('fraisTraitement', parseInt(e.target.value))}
                      className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Pénalité de retard (%)
                    </label>
                    <input
                      type="number"
                      step="0.1"
                      value={config.penaliteRetard}
                      onChange={(e) => handleConfigChange('penaliteRetard', parseFloat(e.target.value))}
                      className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>
                </div>

                <div className="bg-blue-50 border border-blue-200 rounded-lg p-4">
                  <h3 className="font-medium text-blue-900 mb-2">Exemple de calcul</h3>
                  <p className="text-blue-800 text-sm">
                    Pour une collecte de 10 000 {config.devise} :
                    <br />• Montant à collecter : {config.tauxType === 'pourcentage' 
                      ? `10 000 × ${config.tauxPrincipal}% = ${(10000 * config.tauxPrincipal / 100).toLocaleString()} ${config.devise}`
                      : `${config.tauxPrincipal.toLocaleString()} ${config.devise}`}
                    <br />• Frais de traitement : {config.fraisTraitement.toLocaleString()} {config.devise}
                    <br />• <strong>Total : {config.tauxType === 'pourcentage' 
                      ? (10000 * config.tauxPrincipal / 100 + config.fraisTraitement).toLocaleString()
                      : (config.tauxPrincipal + config.fraisTraitement).toLocaleString()} {config.devise}</strong>
                  </p>
                </div>
              </div>
            )}

            {/* Onglet Conditions */}
            {activeTab === 'conditions' && (
              <div className="space-y-6">
                <div className="grid grid-cols-2 gap-6">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Montant minimum par collecte ({config.devise})
                    </label>
                    <input
                      type="number"
                      value={config.montantMinimum}
                      onChange={(e) => handleConfigChange('montantMinimum', parseInt(e.target.value))}
                      className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Montant maximum par collecte ({config.devise})
                    </label>
                    <input
                      type="number"
                      value={config.montantMaximum}
                      onChange={(e) => handleConfigChange('montantMaximum', parseInt(e.target.value))}
                      className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Période d'essai (jours)
                    </label>
                    <input
                      type="number"
                      value={config.periodeEssai}
                      onChange={(e) => handleConfigChange('periodeEssai', parseInt(e.target.value))}
                      className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Notification avant collecte (heures)
                    </label>
                    <input
                      type="number"
                      value={config.notificationAvant}
                      onChange={(e) => handleConfigChange('notificationAvant', parseInt(e.target.value))}
                      className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Devise
                    </label>
                    <select
                      value={config.devise}
                      onChange={(e) => handleConfigChange('devise', e.target.value)}
                      className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                      <option value="XAF">XAF - Franc CFA</option>
                      <option value="EUR">EUR - Euro</option>
                      <option value="USD">USD - Dollar US</option>
                    </select>
                  </div>
                </div>
              </div>
            )}

            {/* Onglet Planning */}
            {activeTab === 'planning' && (
              <div className="space-y-6">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Fréquence de collecte
                  </label>
                  <select
                    value={config.frequence}
                    onChange={(e) => handleConfigChange('frequence', e.target.value)}
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option value="quotidienne">Quotidienne</option>
                    <option value="hebdomadaire">Hebdomadaire</option>
                    <option value="mensuelle">Mensuelle</option>
                  </select>
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-3">
                    <Clock size={18} className="inline mr-2" />
                    Heure de collecte automatique
                  </label>
                  <input
                    type="time"
                    value={config.heureCollecte}
                    onChange={(e) => handleConfigChange('heureCollecte', e.target.value)}
                    className="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-3">
                    Jours de collecte
                  </label>
                  <div className="grid grid-cols-4 gap-3">
                    {jours.map(jour => (
                      <button
                        key={jour}
                        onClick={() => toggleJour(jour)}
                        className={`px-4 py-3 rounded-lg border-2 font-medium transition-all ${
                          config.joursCollecte.includes(jour)
                            ? 'bg-blue-600 text-white border-blue-600'
                            : 'bg-white text-gray-700 border-gray-300 hover:border-blue-400'
                        }`}
                      >
                        {jour.charAt(0).toUpperCase() + jour.slice(1, 3)}
                      </button>
                    ))}
                  </div>
                  <p className="text-sm text-gray-600 mt-2">
                    Jours sélectionnés : {config.joursCollecte.length > 0 
                      ? config.joursCollecte.join(', ') 
                      : 'Aucun jour sélectionné'}
                  </p>
                </div>
              </div>
            )}

            {/* Onglet Paliers */}
            {activeTab === 'paliers' && (
              <div className="space-y-6">
                <div className="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                  <p className="text-yellow-800 text-sm">
                    Les paliers progressifs permettent d'appliquer des taux différents selon le montant collecté.
                  </p>
                </div>

                <div className="space-y-4">
                  {paliers.map((palier, index) => (
                    <div key={index} className="bg-gray-50 p-4 rounded-lg border border-gray-200">
                      <div className="grid grid-cols-3 gap-4">
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Montant min ({config.devise})
                          </label>
                          <input
                            type="number"
                            value={palier.min}
                            onChange={(e) => {
                              const newPaliers = [...paliers];
                              newPaliers[index].min = parseInt(e.target.value);
                              setPaliers(newPaliers);
                            }}
                            className="w-full px-4 py-2 border border-gray-300 rounded-lg"
                          />
                        </div>
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Montant max ({config.devise})
                          </label>
                          <input
                            type="number"
                            value={palier.max}
                            onChange={(e) => {
                              const newPaliers = [...paliers];
                              newPaliers[index].max = parseInt(e.target.value);
                              setPaliers(newPaliers);
                            }}
                            className="w-full px-4 py-2 border border-gray-300 rounded-lg"
                          />
                        </div>
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Taux (%)
                          </label>
                          <input
                            type="number"
                            step="0.1"
                            value={palier.taux}
                            onChange={(e) => {
                              const newPaliers = [...paliers];
                              newPaliers[index].taux = parseFloat(e.target.value);
                              setPaliers(newPaliers);
                            }}
                            className="w-full px-4 py-2 border border-gray-300 rounded-lg"
                          />
                        </div>
                      </div>
                    </div>
                  ))}
                </div>

                <button
                  onClick={() => setPaliers([...paliers, { min: 0, max: 0, taux: 0 }])}
                  className="text-blue-600 hover:text-blue-700 font-medium"
                >
                  + Ajouter un palier
                </button>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}