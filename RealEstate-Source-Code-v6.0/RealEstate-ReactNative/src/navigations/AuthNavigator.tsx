import { createStackNavigator } from "@react-navigation/stack";
import React from "react";

import { LoginScreen, RegisterScreen } from "../screens";
import NavigationNames from "./NavigationNames";

const RootStack = createStackNavigator();

export default function () {
  return (
    <RootStack.Navigator
      screenOptions={{ headerShown: false, headerMode: "screen" }}
    >
      <RootStack.Screen
        name={NavigationNames.LoginScreen}
        component={LoginScreen}
      />
      <RootStack.Screen
        name={NavigationNames.RegisterScreen}
        component={RegisterScreen}
      />
    </RootStack.Navigator>
  );
}
