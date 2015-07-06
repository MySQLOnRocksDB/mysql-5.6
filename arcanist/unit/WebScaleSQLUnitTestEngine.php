<?php
// Copyright 2004-present Facebook. All Rights Reserved.

final class WebScaleSQLUnitTestEngine extends ArcanistBaseUnitTestEngine {
  public function run() {
    // If we are running asynchronously, mark all tests as postponed
    // and return those results.
    if ($this->getEnableAsyncTests()) {
      $results = array();
      $buildTypes = array(
        "Release",
        "ASan",
        "Debug"
      );
      $testSets = array(
        "MixedOther",
        "StressSerial",
        "StressNoMem",
        "PerfSchemaOther"
      );
      $pageSizes = array(
        "16",
        "32"
      );
      $clientModes = array(
        "Sync",
        "Async"
      );
      foreach ($buildTypes as $buildType) {
        foreach ($testSets as $testSet) {
          foreach ($pageSizes as $pageSize) {
            foreach ($clientModes as $clientMode) {
              if (!(($pageSize=="16" && $clientMode=="Sync")
                    || ($pageSize=="32" && $clientMode=="Async"))) {
                $result = new ArcanistUnitTestResult();
                $result->setName("$buildType$testSet$pageSize$clientMode");
                $result->setResult(ArcanistUnitTestResult::RESULT_POSTPONED);
                $results[] = $result;
              }
            }
          }
        }
      }
      return $results;
    }
  }

}
